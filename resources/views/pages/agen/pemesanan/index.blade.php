@extends('layouts.agen.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Daftar Pemesanan Masuk</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Petani</th>
                                <th>Lokasi Jemput</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemesanan as $p)
                                <tr>
                                    <td>{{ $p->petani->nama ?? '-' }}</td>
                                    <td>{{ $p->lokasi_jemput }}</td>
                                    <td>{{ $p->tanggal_pemesanan }}</td>
                                    <td>{{ $p->jenis_pemesanan }}</td>
                                    <td><span class="badge badge-warning">{{ $p->status_pemesanan }}</span></td>
                                    <td>
                                        <a href="{{ route('agen.pemesanan.show', $p->id) }}"
                                            class="btn btn-primary btn-sm">Kelola</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Tidak ada pemesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection