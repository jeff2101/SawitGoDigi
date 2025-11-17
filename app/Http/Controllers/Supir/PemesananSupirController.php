<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananSupirController extends Controller
{
    /**
     * Menampilkan daftar pemesanan aktif untuk supir
     */
    public function index()
    {
        $supirId = Auth::guard('supir')->id();

        $pemesanan = Pemesanan::where('id_supir', $supirId)
            ->whereIn('status_pemesanan', ['proses', 'dijemput']) // hanya status aktif
            ->paginate(10);

        return view('pages.supir.pemesanan.index', compact('pemesanan'));
    }

    /**
     * Menampilkan detail dari satu pemesanan
     */
    public function show($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        return view('pages.supir.pemesanan.show', compact('pemesanan'));
    }

    /**
     * Mengubah status pemesanan oleh supir
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pemesanan' => 'required|in:dijemput,proses_transaksi',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status_pemesanan = $request->status_pemesanan;
        $pemesanan->save();

        return redirect()->route('supir.pemesanan.index')
            ->with('success', 'Status pemesanan berhasil diperbarui.');
    }

    /**
     * Supir mengirim update lokasi secara berkala.
     * Lokasi hanya akan dikirim jika supir masih memiliki tugas aktif.
     */
    public function updateLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $supir = Auth::guard('supir')->user();

        // ❌ Cegah update lokasi jika tidak ada tugas aktif
        $hasActiveOrder = Pemesanan::where('id_supir', $supir->id)
            ->whereIn('status_pemesanan', ['proses', 'dijemput'])
            ->exists();

        if (!$hasActiveOrder) {
            return response()->json([
                'message' => 'Tidak ada tugas aktif. Lokasi tidak dikirim.',
            ], 204); // 204 No Content
        }

        // ✅ Update lokasi jika ada tugas aktif
        $supir->latitude = $request->latitude;
        $supir->longitude = $request->longitude;
        $supir->last_updated_location = now();
        $supir->save();

        return response()->json([
            'message' => 'Lokasi berhasil diperbarui.',
            'lat' => $supir->latitude,
            'lng' => $supir->longitude,
        ]);
    }

    /**
     * Menampilkan tugas aktif supir (untuk View Detail dari Dashboard)
     */
    public function tugasAktif()
    {
        $supirId = Auth::guard('supir')->id();

        $pemesananAktif = Pemesanan::where('id_supir', $supirId)
            ->whereIn('status_pemesanan', ['proses', 'dijemput'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('pages.supir.pemesanan.aktif', compact('pemesananAktif'));
    }
}
