<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Supir;
use Illuminate\Http\Request;

class PemesananAgenController extends Controller
{
    // 1. Tampilkan semua pemesanan pending
    public function index()
    {
        $pemesanan = Pemesanan::where('status_pemesanan', 'pending')->get();
        return view('pages.agen.pemesanan.index', compact('pemesanan'));
    }

    // 2. Tampilkan detail dan form assign supir
    public function show($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $supirs = Supir::all(); // Supir bisa difilter per agen jika perlu

        return view('pages.agen.pemesanan.show', compact('pemesanan', 'supirs'));
    }

    // 3. Simpan penugasan supir ke pemesanan
    public function assignSupir(Request $request, $id)
    {
        $request->validate([
            'id_supir' => 'required|exists:sw_supirs,id',
        ]);

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->id_supir = $request->id_supir;
        $pemesanan->status_pemesanan = 'proses'; // atau 'dijemput' jika langsung
        $pemesanan->save();

        return redirect()->route('agen.pemesanan.index')
            ->with('success', 'Supir berhasil ditugaskan.');
    }
}
