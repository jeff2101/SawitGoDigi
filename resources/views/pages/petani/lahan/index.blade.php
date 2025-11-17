@extends('layouts.petani.app')

@section('content')
    <div class="container">
        <h1>Daftar Lahan</h1>

        <a href="{{ route('petani.lahan.create') }}" class="btn btn-primary mb-3">Tambah Lahan</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($lahans->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Lahan</th>
                        <th>Lokasi</th>
                        <th>Luas (ha)</th>
                        <th>Maps URL</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lahans as $lahan)
                        <tr>
                            <td>{{ $lahan->nama }}</td>
                            <td>{{ $lahan->lokasi }}</td>
                            <td>{{ number_format($lahan->luas, 2) }}</td>
                            <td>
                                @if($lahan->latitude && $lahan->longitude)
                                    <a href="https://www.google.com/maps?q={{ $lahan->latitude }},{{ $lahan->longitude }}"
                                        target="_blank" class="btn btn-sm btn-info">
                                        Lihat di Google Maps
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('petani.lahan.edit', $lahan->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('petani.lahan.destroy', $lahan->id) }}" method="POST"
                                    style="display:inline-block; margin-left:5px;"
                                    onsubmit="return confirm('Yakin ingin menghapus data lahan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $lahans->withQueryString()->links() }}

        @else
            <p>Tidak ada data lahan.</p>
        @endif
    </div>
@endsection