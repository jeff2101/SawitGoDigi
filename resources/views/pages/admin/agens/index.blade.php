@extends('layouts.admin.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Agen</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Agen</h6>
            <a href="{{ route('admin.agens.create') }}" class="btn btn-primary btn-sm">Tambah Agen</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Usaha</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agens as $agen)
                            <tr>
                                <td>{{ $agen->nama }}</td>
                                <td>{{ $agen->email }}</td>
                                <td>{{ $agen->alamat }}</td>
                                <td>{{ $agen->kontak }}</td>
                                <td>{{ $agen->usaha ? $agen->usaha->nama_usaha : '-' }}</td>
                                <td>{{ $agen->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.agens.edit', ['id' => $agen->id]) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('admin.agens.destroy', ['id' => $agen->id]) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus agen ini?');">
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
