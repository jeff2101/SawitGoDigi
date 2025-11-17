@extends('layouts.admin.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Usaha</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Usaha</h6>
            <a href="{{ route('admin.usahas.create') }}" class="btn btn-primary btn-sm">Tambah Usaha</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Usaha</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usahas as $usaha)
                            <tr>
                                <td>{{ $usaha->id }}</td>
                                <td>{{ $usaha->nama_usaha }}</td>
                                <td>{{ $usaha->alamat }}</td>
                                <td>{{ $usaha->kontak }}</td>
                                <td>{{ $usaha->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.usahas.edit', ['id' => $usaha->id]) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('admin.usahas.destroy', ['id' => $usaha->id]) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus usaha ini?');">
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
