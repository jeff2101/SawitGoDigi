@extends('layouts.petani.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Informasi Harga Jual</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($hargaJuals->count())
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
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
                                    <td>Rp {{ number_format($harga->harga_tbs, 0, ',', '.') }}</td>
                                    <td>
                                        {{ $harga->harga_brondol !== null
                            ? 'Rp ' . number_format($harga->harga_brondol, 0, ',', '.')
                            : '-' }}
                                    </td>
                                    <td>{{ $harga->waktu_ditetapkan ? $harga->waktu_ditetapkan->format('d-m-Y H:i') : '-' }}</td>
                                    <td>{{ $harga->catatan ?? '-' }}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $hargaJuals->links() }}
            </div>
        @else
            <p class="text-muted">Belum ada data harga jual yang tersedia.</p>
        @endif
    </div>
@endsection