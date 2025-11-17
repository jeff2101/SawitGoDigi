<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    /**
     * Daftar semua item galeri.
     */
    public function index()
    {
        $galleryItems = GalleryItem::orderByDesc('id')->get();

        return view('pages.admin.gallery-items.index', compact('galleryItems'));
    }

    /**
     * Form tambah foto galeri.
     */
    public function create()
    {
        return view('pages.admin.gallery-items.create');
    }

    /**
     * Simpan foto galeri baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB
        ]);

        // Simpan file ke storage/app/public/gallery
        $path = $request->file('image')->store('gallery', 'public');

        GalleryItem::create([
            'judul' => $data['judul'] ?? null,
            'image_path' => $path,
        ]);

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    /**
     * Form edit foto galeri.
     */
    public function edit(GalleryItem $galleryItem)
    {
        return view('pages.admin.gallery-items.edit', compact('galleryItem'));
    }

    /**
     * Update foto galeri.
     */
    public function update(Request $request, GalleryItem $galleryItem)
    {
        $data = $request->validate([
            'judul' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // kalau ada upload gambar baru
        if ($request->hasFile('image')) {
            // hapus file lama kalau ada
            if ($galleryItem->image_path && Storage::disk('public')->exists($galleryItem->image_path)) {
                Storage::disk('public')->delete($galleryItem->image_path);
            }

            $path = $request->file('image')->store('gallery', 'public');
            $galleryItem->image_path = $path;
        }

        $galleryItem->judul = $data['judul'] ?? null;
        $galleryItem->save();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('success', 'Foto galeri berhasil diperbarui.');
    }

    /**
     * Hapus foto galeri.
     */
    public function destroy(GalleryItem $galleryItem)
    {
        if ($galleryItem->image_path && Storage::disk('public')->exists($galleryItem->image_path)) {
            Storage::disk('public')->delete($galleryItem->image_path);
        }

        $galleryItem->delete();

        return redirect()
            ->route('admin.gallery-items.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
