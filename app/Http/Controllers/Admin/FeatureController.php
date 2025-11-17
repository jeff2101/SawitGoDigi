<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Tampilkan daftar semua fitur.
     */
    public function index()
    {
        $features = Feature::orderBy('id')->get();

        return view('pages.admin.features.index', compact('features'));
    }

    /**
     * Tampilkan form tambah fitur baru.
     */
    public function create()
    {
        return view('pages.admin.features.create');
    }

    /**
     * Simpan fitur baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => 'required|string|max:255',   // contoh: "bi bi-pencil-square"
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Feature::create($data);

        return redirect()
            ->route('admin.features.index')
            ->with('success', 'Fitur baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit fitur.
     */
    public function edit(Feature $feature)
    {
        return view('pages.admin.features.edit', compact('feature'));
    }

    /**
     * Update fitur yang sudah ada.
     */
    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'icon' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $feature->update($data);

        return redirect()
            ->route('admin.features.index')
            ->with('success', 'Fitur berhasil diperbarui.');
    }

    /**
     * Hapus fitur.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect()
            ->route('admin.features.index')
            ->with('success', 'Fitur berhasil dihapus.');
    }
}
