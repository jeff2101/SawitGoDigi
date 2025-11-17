@extends('layouts.admin.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Petani</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Petani</h6>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
