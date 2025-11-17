<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Petani;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // Potongan mutu buah dalam persen
    private $potonganMutu = [
        'mentah' => 10,
        'matang' => 0,
        'busuk' => 20,
    ];

    // Menampilkan semua transaksi milik agen yang login
    public function index()
    {
        $agenId = Auth::guard('agen')->id();

        // Pastikan agen hanya melihat transaksinya sendiri
        $transaksis = Transaksi::where('agen_id', $agenId)->latest()->get();

        return view('pages.agen.transaksi.index', compact('transaksis'));
    }

    // Form untuk tambah transaksi baru
    public function create()
    {
        // Menggunakan model Eloquent untuk mengambil data petani dan pemesanan
        $petanis = Petani::all();
        $pemesanans = Pemesanan::where('status_pemesanan', 'proses_transaksi')->get();

        return view('pages.agen.transaksi.create', compact('petanis', 'pemesanans'));
    }

    // Endpoint untuk mendapatkan data pemesanan via AJAX
    public function getPemesanan($id)
    {
        $pemesanan = Pemesanan::with('petani')->find($id);

        if (!$pemesanan) {
            return response()->json(['error' => 'Pemesanan tidak ditemukan'], 404);
        }

        return response()->json([
            'petani_id' => $pemesanan->id_petani,
            'petani_nama' => $pemesanan->petani->nama ?? '',
            'estimasi_berat' => $pemesanan->bobot_estimasi ?? 0, // Ganti ini
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'petani_id' => 'nullable|exists:sw_petanis,id',
            'pemesanan_id' => 'nullable|exists:sw_pemesanans,id',
            'jenis_transaksi' => 'required|in:langsung,pesanan',
            'berat_tbs_a' => 'nullable|numeric|min:0',
            'berat_tbs_b' => 'nullable|numeric|min:0',
            'berat_brondol' => 'nullable|numeric|min:0',
            'harga_tbs_a' => 'nullable|numeric|min:0',
            'harga_tbs_b' => 'nullable|numeric|min:0',
            'harga_brondol' => 'nullable|numeric|min:0',
            'potongan_berat' => 'nullable|numeric|min:0|max:100',
            'potongan_alas_timbang' => 'nullable|numeric|min:0',
            'mutu_buah_a' => 'required|in:mentah,matang,busuk',
            'mutu_buah_b' => 'required|in:mentah,matang,busuk',
            'mutu_buah' => 'required|in:mentah,matang,busuk',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'tanggal' => 'nullable|date',
            'bukti_transaksi' => 'nullable|string|max:255',
        ]);

        $agenId = Auth::guard('agen')->id();
        $hargaJual = $this->getLatestHargaJual($agenId);
        if (!$hargaJual) {
            return back()->with('error', 'Harga jual belum ditetapkan.');
        }

        // Ambil input
        $berat_tbs_a = $request->berat_tbs_a ?? 0;
        $berat_tbs_b = $request->berat_tbs_b ?? 0;
        $berat_brondol = $request->berat_brondol ?? 0;

        $harga_tbs_a = $request->harga_tbs_a ?? 0;
        $harga_tbs_b = $request->harga_tbs_b ?? 0;
        $harga_brondol = $request->harga_brondol ?? 0;

        $potongan_persen = $request->potongan_berat ?? 0;
        $potongan_alas = $request->potongan_alas_timbang ?? 0;

        // Buah A
        $bersih_a = ($berat_tbs_a - $potongan_alas) * (1 - $potongan_persen / 100);
        $bersih_a = max(0, $bersih_a);
        $total_a = $bersih_a * $harga_tbs_a;

        // Buah B
        $bersih_b = ($berat_tbs_b - $potongan_alas) * (1 - $potongan_persen / 100);
        $bersih_b = max(0, $bersih_b);
        $total_b = $bersih_b * $harga_tbs_b;

        // Brondol
        $bersih_brondol = ($berat_brondol - $potongan_alas) * (1 - $potongan_persen / 100);
        $bersih_brondol = max(0, $bersih_brondol);
        $total_brondol = $bersih_brondol * $harga_brondol;

        // Total dan validasi akhir
        $total_harga_awal = $total_a + $total_b + $total_brondol;
        $total_bersih = $total_harga_awal;

        if ($total_bersih <= 0) {
            return back()->with('error', 'Total bersih tidak boleh 0 atau negatif.');
        }

        $transaksi = Transaksi::create([
            'agen_id' => $agenId,
            'petani_id' => $request->petani_id,
            'pemesanan_id' => $request->pemesanan_id,
            'jenis_transaksi' => $request->jenis_transaksi,

            'berat_tbs' => $bersih_a + $bersih_b,
            'berat_brondol' => $bersih_brondol,
            'berat_tbs_a' => $berat_tbs_a,
            'berat_tbs_b' => $berat_tbs_b,
            'harga_tbs_a' => $harga_tbs_a,
            'harga_tbs_b' => $harga_tbs_b,
            'harga_brondol' => $harga_brondol,

            'potongan_persen' => $potongan_persen,
            'potongan_alas_timbang' => $potongan_alas,

            'mutu_buah' => $request->mutu_buah,
            'mutu_buah_a' => $request->mutu_buah_a,
            'mutu_buah_b' => $request->mutu_buah_b,

            'harga_tbs' => $hargaJual->harga_tbs,
            'total_harga_awal' => $total_harga_awal,
            'total_bersih' => $total_bersih,

            'tanggal' => $request->tanggal ?? now(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_transaksi' => $request->bukti_transaksi,
        ]);

        if ($transaksi->pemesanan_id) {
            Pemesanan::where('id', $transaksi->pemesanan_id)
                ->update(['status_pemesanan' => 'selesai']);
        }

        return redirect()->route('agen.transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }


    public function riwayat()
    {
        $agenId = Auth::guard('agen')->id();
        $transaksis = Transaksi::where('agen_id', $agenId)->latest()->get();

        return view('pages.agen.riwayat.index', compact('transaksis'));
    }

    public function nota($id)
    {
        $transaksi = Transaksi::with('agen', 'petani')->findOrFail($id);
        return view('pages.agen.transaksi.nota', compact('transaksi'));
    }
    public function printNota($id)
    {
        $transaksi = Transaksi::with(['agen', 'petani'])->findOrFail($id);
        return view('pages.agen.transaksi.nota_print', compact('transaksi'));
    }


    // Fungsi untuk mendapatkan harga jual terbaru berdasarkan agen
    private function getLatestHargaJual($agenId)
    {
        return \DB::table('sw_harga_juals')
            ->where('agen_id', $agenId)
            ->orderByDesc('waktu_ditetapkan')
            ->first();
    }

}
