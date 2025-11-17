@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Supir</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Supir</h6>
            <a href="{{ route('agen.supirs.create') }}" class="btn btn-primary btn-sm">Tambah Supir</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Email</th>
                            <th>Jenis Kendaraan</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supirs as $supir)
                            <tr>
                                <td>{{ $supir->nama }}</td>
                                <td>{{ $supir->kontak }}</td>
                                <td>{{ $supir->email }}</td>
                                <td>{{ $supir->jenis_kendaraan }}</td>
                                <td>{{ $supir->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('agen.supirs.edit', ['id' => $supir->id]) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('agen.supirs.destroy', ['id' => $supir->id]) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus supir ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection