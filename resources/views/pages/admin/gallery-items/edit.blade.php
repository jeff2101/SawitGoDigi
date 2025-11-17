@extends('layouts.admin.app')

@section('title', 'Edit Foto Galeri')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Foto Galeri</h1>
            <a href="{{ route('admin.gallery-items.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Foto Galeri</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.gallery-items.update', $galleryItem) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- JUDUL --}}
                            <div class="form-group">
                                <label for="judul">Judul / Caption (opsional)</label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul', $galleryItem->judul) }}"
                                    placeholder="misal: Pengangkutan hasil panen">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FOTO BARU (opsional) --}}
                            <div class="form-group">
                                <label for="image">Foto Baru (opsional)</label>
                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror">
                                <small class="text-muted d-block">
                                    Biarkan kosong jika tidak ingin mengganti foto.
                                </small>
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Preview foto --}}
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Preview Foto</h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $galleryItem->image_path) }}" alt="{{ $galleryItem->judul }}"
                            style="width: 100%; max-width: 260px; height: 180px; object-fit: cover;">
                        <p class="mt-2 mb-0 text-muted" style="font-size: 0.9rem;">
                            {{ $galleryItem->judul ?? '(tanpa judul)' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection