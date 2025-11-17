@extends('layouts.admin.app')

@section('title', 'Tambah Foto Galeri')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Foto Galeri</h1>
            <a href="{{ route('admin.gallery-items.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Foto Galeri</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.gallery-items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- JUDUL --}}
                            <div class="form-group">
                                <label for="judul">Judul / Caption (opsional)</label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}"
                                    placeholder="misal: Pengangkutan hasil panen">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FOTO --}}
                            <div class="form-group">
                                <label for="image">Foto Galeri</label>
                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror">
                                <small class="text-muted d-block">
                                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                </small>
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Info kecil --}}
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tips Foto</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            Gunakan foto dengan resolusi yang cukup agar tampilan galeri di halaman depan tetap tajam.
                        </p>
                        <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                            Di frontend, foto akan dipotong otomatis dengan <code>object-fit: cover</code>, jadi pastikan
                            objek utama ada di tengah gambar.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection