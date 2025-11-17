<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga_Jual;

class HargaJualController extends Controller
{
    /**
     * Tampilkan daftar harga jual
     */
    public function index()
    {
        $hargaJuals = Harga_Jual::with('agen')->paginate(10);
        return view('pages.agen.hargajual.index', compact('hargaJuals'));
    }

    /**
     * Tampilkan form tambah harga jual
     */
    public function create()
    {
        return view('pages.agen.hargajual.create');
    }

    /**
     * Simpan data harga jual baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agen_id' => 'required|exists:sw_agens,id',
            'harga_tbs' => 'required|numeric',
            'harga_brondol' => 'nullable|numeric',
            'waktu_ditetapkan' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        Harga_Jual::create($validated);

        return redirect()->route('agen.hargajual.index')->with('success', 'Data harga jual berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit harga jual
     */
    public function edit($id)
    {
        $hargaJual = Harga_Jual::findOrFail($id);
        return view('pages.agen.hargajual.edit', compact('hargaJual'));
    }

    /**
     * Update data harga jual
     */
    public function update(Request $request, $id)
    {
        $hargaJual = Harga_Jual::findOrFail($id);

        $validated = $request->validate([
            'agen_id' => 'required|exists:sw_agens,id',
            'harga_tbs' => 'required|numeric',
            'harga_brondol' => 'nullable|numeric',
            'waktu_ditetapkan' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        $hargaJual->update($validated);

        return redirect()->route('agen.hargajual.index')->with('success', 'Data harga jual berhasil diperbarui.');
    }
}
