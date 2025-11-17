<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;

class LahanController extends Controller
{
    /**
     * Tampilkan daftar lahan milik petani yang login
     */
    public function index()
    {
        $petaniId = auth()->guard('petani')->user()->id;
        $lahans = Lahan::where('id_petani', $petaniId)->paginate(10);

        return view('pages.petani.lahan.index', compact('lahans'));
    }

    /**
     * Tampilkan form tambah lahan
     */
    public function create()
    {
        return view('pages.petani.lahan.create');
    }

    /**
     * Simpan data lahan baru
     */
    public function store(Request $request)
    {
        $petaniId = auth()->guard('petani')->user()->id;

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'luas' => 'required|numeric',
            'maps_url' => 'nullable|url|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Tambahkan id_petani ke data yang divalidasi
        $validated['id_petani'] = $petaniId;

        Lahan::create($validated);

        return redirect()->route('petani.lahan.index')
            ->with('success', 'Data lahan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit lahan
     */
    public function edit($id)
    {
        $petaniId = auth()->guard('petani')->user()->id;

        // Pastikan lahan milik petani yang login
        $lahan = Lahan::where('id_petani', $petaniId)->findOrFail($id);

        return view('pages.petani.lahan.edit', compact('lahan'));
    }

    /**
     * Update data lahan
     */
    public function update(Request $request, $id)
    {
        $petaniId = auth()->guard('petani')->user()->id;

        // Pastikan lahan milik petani yang login
        $lahan = Lahan::where('id_petani', $petaniId)->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'luas' => 'required|numeric',
            'maps_url' => 'nullable|url|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lahan->update($validated);

        return redirect()->route('petani.lahan.index')
            ->with('success', 'Data lahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petaniId = auth()->guard('petani')->user()->id;

        // Pastikan lahan milik petani yang login
        $lahan = Lahan::where('id_petani', $petaniId)->findOrFail($id);

        $lahan->delete();

        return redirect()->route('petani.lahan.index')
            ->with('success', 'Data lahan berhasil dihapus.');
    }
}
