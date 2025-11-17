<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    /**
     * Tampilkan form edit Visi & Misi
     */
    public function edit()
    {
        // Selalu pakai satu record saja
        $visiMisi = VisiMisi::first();

        // Kalau belum ada, buat default
        if (!$visiMisi) {
            $visiMisi = VisiMisi::create([
                'visi' => 'Menjadi platform digital terpercaya yang merevolusi sistem pencatatan, distribusi, dan transaksi hasil panen sawit di Indonesia.',
                'misi' => "Memberikan kemudahan pencatatan panen bagi petani dan agen secara digital.\nMenyediakan sistem transaksi yang transparan dan aman.\nMeningkatkan produktivitas dan efisiensi melalui integrasi data panen.\nMemberdayakan petani kecil dengan teknologi yang inklusif dan mudah diakses.",
            ]);
        }

        return view('pages.admin.visi-misi.edit', compact('visiMisi'));
    }

    /**
     * Proses update Visi & Misi
     */
    public function update(Request $request)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        $visiMisi = VisiMisi::first() ?? new VisiMisi();

        $visiMisi->visi = $request->visi;
        $visiMisi->misi = $request->misi;
        $visiMisi->save();

        return redirect()
            ->route('admin.visimisi.edit')
            ->with('success', 'Visi & Misi berhasil diperbarui.');
    }
}
