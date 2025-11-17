@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Petani</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Petani</h6>
            <a href="{{ route('agen.petanis.create') }}" class="btn btn-primary btn-sm">Tambah Petani</a>
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
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($petanis as $petani)
                            <tr>
                                <td>{{ $petani->nama }}</td>
                                <td>{{ $petani->email }}</td>
                                <td>{{ $petani->alamat }}</td>
                                <td>{{ $petani->kontak }}</td>
                                <td>{{ $petani->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('agen.petanis.edit', ['id' => $petani->id]) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('agen.petanis.destroy', ['id' => $petani->id]) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Yakin ingin menghapus petani ini?');">
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
