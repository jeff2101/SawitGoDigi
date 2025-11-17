@extends('layouts.admin.app') {{-- sesuaikan dengan layout admin kamu --}}

@section('title', 'Fitur')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Fitur</h1>
            <a href="{{ route('admin.features.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Fitur Baru
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
                <h6 class="m-0 font-weight-bold text-primary">Fitur Halaman Depan</h6>
            </div>
            <div class="card-body">
                @if($features->isEmpty())
                    <p class="mb-0 text-muted">Belum ada fitur yang ditambahkan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th style="width: 80px;">Icon</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($features as $index => $feature)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-center">
                                            <i class="{{ $feature->icon }}"></i>
                                        </td>
                                        <td>{{ $feature->judul }}</td>
                                        <td style="max-width: 400px;">
                                            {{ \Illuminate\Support\Str::limit($feature->deskripsi, 120) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.features.edit', $feature) }}"
                                                class="btn btn-sm btn-warning mb-1">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.features.destroy', $feature) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus fitur ini?');">
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