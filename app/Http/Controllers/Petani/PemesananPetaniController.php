<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Lahan;
use Illuminate\Support\Facades\Auth;

class PemesananPetaniController extends Controller
{
    public function index()
    {
        $petaniId = Auth::guard('petani')->id();
        $pemesanans = Pemesanan::where('id_petani', $petaniId)
            ->with('lahan')
            ->latest()
            ->paginate(10);

        return view('pages.petani.pemesanan.index', compact('pemesanans'));
    }

    public function create()
    {
        $petaniId = Auth::guard('petani')->id();
        $lahans = Lahan::where('id_petani', $petaniId)->get();

        return view('pages.petani.pemesanan.create', compact('lahans'));
    }

    public function store(Request $request)
    {
        $petaniId = Auth::guard('petani')->id();

        $validated = $request->validate([
            'id_lahan' => 'nullable|exists:sw_lahans,id',
            'lokasi_jemput' => 'required|string|max:255',
            'google_maps_url' => 'nullable|url|max:500',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'bobot_estimasi' => 'required|numeric|min:0',
            'jenis_pemesanan' => 'required|in:buah_petani,buah_pt',
            'tanggal_pemesanan' => 'required|date|after_or_equal:today',
        ]);

        $validated['id_petani'] = $petaniId;
        $validated['status_pemesanan'] = 'pending';

        Pemesanan::create($validated);

        return redirect()->route('petani.pemesanan.index')
            ->with('success', 'Pemesanan berhasil dibuat.');
    }

    public function show($id)
    {
        $petaniId = Auth::guard('petani')->id();
        $pemesanan = Pemesanan::where('id_petani', $petaniId)->with('lahan')->findOrFail($id);

        return view('pages.petani.pemesanan.show', compact('pemesanan'));
    }

    public function batal($id)
    {
        $petaniId = Auth::guard('petani')->id();
        $pemesanan = Pemesanan::where('id_petani', $petaniId)->findOrFail($id);

        if (in_array($pemesanan->status_pemesanan, ['pending', 'proses'])) {
            $pemesanan->status_pemesanan = 'dibatalkan';
            $pemesanan->save();

            return redirect()->route('petani.pemesanan.index')
                ->with('success', 'Pemesanan berhasil dibatalkan.');
        }

        return redirect()->route('petani.pemesanan.index')
            ->with('error', 'Pemesanan tidak dapat dibatalkan karena sudah dijemput atau selesai.');
    }

    public function destroy($id)
    {
        $petaniId = Auth::guard('petani')->id();
        $pemesanan = Pemesanan::where('id_petani', $petaniId)->findOrFail($id);

        if ($pemesanan->status_pemesanan !== 'dibatalkan') {
            return redirect()->route('petani.pemesanan.index')
                ->with('error', 'Hanya pemesanan yang dibatalkan yang dapat dihapus.');
        }

        $pemesanan->delete();

        return redirect()->route('petani.pemesanan.index')
            ->with('success', 'Pemesanan berhasil dihapus.');
    }

    /**
     * Tampilkan form edit
     */
    public function edit($id)
    {
        $petaniId = Auth::guard('petani')->id();
        $pemesanan = Pemesanan::where('id_petani', $petaniId)->findOrFail($id);
        $lahans = Lahan::where('id_petani', $petaniId)->get();

        return view('pages.petani.pemesanan.edit', compact('pemesanan', 'lahans'));
    }

    /**
     * Update data pemesanan
     */
    public function update(Request $request, $id)
    {
        $petaniId = Auth::guard('petani')->id();
        $pemesanan = Pemesanan::where('id_petani', $petaniId)->findOrFail($id);

        if (!in_array($pemesanan->status_pemesanan, ['pending', 'proses'])) {
            return redirect()->route('petani.pemesanan.index')
                ->with('error', 'Pemesanan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'id_lahan' => 'nullable|exists:sw_lahans,id',
            'lokasi_jemput' => 'required|string|max:255',
            'google_maps_url' => 'nullable|url|max:500',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'bobot_estimasi' => 'required|numeric|min:0',
            'jenis_pemesanan' => 'required|in:buah_petani,buah_pt',
            'tanggal_pemesanan' => 'required|date|after_or_equal:today',
        ]);

        $pemesanan->update($validated);

        return redirect()->route('petani.pemesanan.index')
            ->with('success', 'Pemesanan berhasil diperbarui.');
    }
}
