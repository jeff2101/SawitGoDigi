@extends('layouts.admin.app')

@section('title', 'Galeri Item')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Galeri Kegiatan</h1>
            <a href="{{ route('admin.gallery-items.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Foto
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Foto Galeri</h6>
            </div>
            <div class="card-body">
                @if($galleryItems->isEmpty())
                    <p class="mb-0 text-muted">Belum ada foto galeri yang ditambahkan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th style="width: 120px;">Foto</th>
                                    <th>Judul / Caption</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($galleryItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->judul }}"
                                                style="width: 100px; height: 70px; object-fit: cover;">
                                        </td>
                                        <td>{{ $item->judul ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.gallery-items.edit', $item) }}"
                                                class="btn btn-sm btn-warning mb-1">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.gallery-items.destroy', $item) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection