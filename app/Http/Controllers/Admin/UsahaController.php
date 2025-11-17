<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usaha;

class UsahaController extends Controller
{
    public function index()
    {
        $usahas = Usaha::all();
        return view('pages.admin.usahas.index', compact('usahas'));
    }

    public function create()
    {
        return view('pages.admin.usahas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:20',
        ]);

        Usaha::create($request->only('nama_usaha', 'alamat', 'kontak'));

        return redirect()->route('admin.usahas.index')->with('success', 'Usaha berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $usaha = Usaha::findOrFail($id);
        return view('pages.admin.usahas.edit', compact('usaha'));
    }

    public function update(Request $request, $id)
    {
        $usaha = Usaha::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:20',
        ]);

        $usaha->update($request->only('nama_usaha', 'alamat', 'kontak'));

        return redirect()->route('admin.usahas.index')->with('success', 'Usaha berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $usaha = Usaha::findOrFail($id);
        $usaha->delete();

        return redirect()->route('admin.usahas.index')->with('success', 'Usaha berhasil dihapus.');
    }
}
