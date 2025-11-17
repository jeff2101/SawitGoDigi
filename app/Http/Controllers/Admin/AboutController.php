<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function edit()
    {
        // pastikan selalu ada 1 data about
        $about = About::first();

        if (!$about) {
            $about = About::create([
                'judul' => 'Digitalisasi Pencatatan Hasil Panen Kelapa Sawit',
                'deskripsi' => 'SawitGoDigi adalah aplikasi pencatatan hasil panen kelapa sawit berbasis web dan mobile ...',
            ]);
        }

        return view('pages.admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $about = About::first();

        // kalau entah kenapa belum ada, buat dulu
        if (!$about) {
            $about = new About();
        }

        $about->judul = $request->judul;
        $about->deskripsi = $request->deskripsi;
        $about->save();

        return redirect()
            ->route('admin.about.edit')
            ->with('success', 'Konten Tentang Kami berhasil diperbarui.');
    }
}
