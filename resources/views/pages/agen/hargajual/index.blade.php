@extends('layouts.agen.app')

@section('content')
    <div class="container">
        <h1>Daftar Harga Jual</h1>

        {{-- Tombol aksi atas --}}
        <div class="mb-3">
            @if(!$hargaJuals->count())
                <a href="{{ route('agen.hargajual.create') }}" class="btn btn-primary">Tambah Harga Jual</a>
            @else
                <a href="{{ route('agen.hargajual.edit', $hargaJuals->first()->id) }}" class="btn btn-warning">Ubah Harga Jual</a>
            @endif
        </div>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabel harga jual --}}
        @if($hargaJuals->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Agen</th>
                        <th>Harga TBS / Kg</th>
                        <th>Harga Brondol / Kg</th>
                        <th>Waktu Ditetapkan</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hargaJuals as $harga)
                        <tr>
                            <td>{{ $harga->agen->nama ?? 'N/A' }}</td>
                            <td>{{ number_format($harga->harga_tbs, 2) }}</td>
                            <td>{{ $harga->harga_brondol !== null ? number_format($harga->harga_brondol, 2) : '-' }}</td>
                            <td>{{ $harga->waktu_ditetapkan ? $harga->waktu_ditetapkan->format('d-m-Y H:i') : '-' }}</td>
                            <td>{{ $harga->catatan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            {{ $hargaJuals->links() }}
        @else
            <p>Tidak ada data harga jual.</p>
        @endif
    </div>
@endsection
