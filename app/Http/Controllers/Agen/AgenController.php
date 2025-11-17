<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agen;
use App\Models\Petani;
use App\Models\Supir;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\Harga_Jual;
use Illuminate\Support\Carbon;

class AgenController extends Controller
{
    public function dashboard(Request $request)
    {
        $agen = Auth::guard('agen')->user();

        // Total Petani (semua)
        $jumlahPetani = Petani::count();

        // Total Supir milik agen ini
        $supirList = Supir::where('agen_id', $agen->id)->get();
        $jumlahSupir = $supirList->count();

        // Supir ID milik agen ini
        $supirIds = $supirList->pluck('id');

        // Pemesanan oleh supir-supir ini
        $pemesananIds = Pemesanan::whereIn('id_supir', $supirIds)->pluck('id');

        // Total transaksi terkait pemesanan
        $transaksiList = Transaksi::whereIn('pemesanan_id', $pemesananIds)->latest()->take(15)->get();
        $jumlahTransaksi = $transaksiList->count();

        // Penjualan bulan ini
        $penjualanBulanan = $transaksiList
            ->where('tanggal', '>=', now()->startOfMonth())
            ->where('tanggal', '<=', now()->endOfMonth())
            ->sum('total_bersih');

        // Harga jual terbaru
        $harga = Harga_Jual::where('agen_id', $agen->id)->latest('waktu_ditetapkan')->first();
        $hargaTbs = $harga->harga_tbs ?? 0;
        $hargaBrondol = $harga->harga_brondol ?? 0;

        // === Chart Penjualan ===
        $range = $request->input('range', '7hari');
        $chartLabels = [];
        $chartData = [];

        if ($range === '7hari') {
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::now()->subDays($i)->toDateString();
                $label = Carbon::parse($tanggal)->format('d M');
                $total = Transaksi::whereIn('pemesanan_id', $pemesananIds)
                    ->whereDate('tanggal', $tanggal)
                    ->sum('total_bersih');
                $chartLabels[] = $label;
                $chartData[] = $total;
            }
        } elseif ($range === 'bulanan') {
            for ($i = 1; $i <= 12; $i++) {
                $label = Carbon::create()->month($i)->format('M');
                $total = Transaksi::whereIn('pemesanan_id', $pemesananIds)
                    ->whereMonth('tanggal', $i)
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->sum('total_bersih');
                $chartLabels[] = $label;
                $chartData[] = $total;
            }
        } elseif ($range === 'tahunan') {
            $currentYear = Carbon::now()->year;
            for ($i = $currentYear - 4; $i <= $currentYear; $i++) {
                $label = (string) $i;
                $total = Transaksi::whereIn('pemesanan_id', $pemesananIds)
                    ->whereYear('tanggal', $i)
                    ->sum('total_bersih');
                $chartLabels[] = $label;
                $chartData[] = $total;
            }
        }

        // Ambil data lengkap untuk modal
        $petanis = Petani::all();
        $supirs = $supirList;
        $transaksis = $transaksiList;

        return view('pages.agen.dashboard', compact(
            'agen',
            'jumlahPetani',
            'jumlahSupir',
            'jumlahTransaksi',
            'penjualanBulanan',
            'hargaTbs',
            'hargaBrondol',
            'range',
            'chartLabels',
            'chartData',
            'petanis',
            'supirs',
            'transaksis'
        ));
    }

    public function profile()
    {
        $agen = Auth::guard('agen')->user();
        return view('pages.agen.profile', compact('agen'));
    }

    // Update agen profile
    public function updateProfile(Request $request)
    {
        $agen = Auth::guard('agen')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $agen->nama = $request->nama;
        $agen->alamat = $request->alamat;
        $agen->kontak = $request->no_hp;

        if ($request->hasFile('foto')) {
            if ($agen->foto && file_exists(public_path('img/' . $agen->foto))) {
                unlink(public_path('img/' . $agen->foto));
            }

            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img'), $imageName);
            $agen->foto = $imageName;
        }

        $agen->save();

        return redirect()->route('agen.profile')->with('success', 'Profil berhasil diperbarui.');
    }

}
