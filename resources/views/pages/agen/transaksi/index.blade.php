@extends('layouts.agen.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Riwayat Transaksi</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Petani</th>
                                <th>Buah A (Kg)</th>
                                <th>Buah B (Kg)</th>
                                <th>Brondol (Kg)</th>
                                <th>Mutu A</th>
                                <th>Mutu B</th>
                                <th>Total Bersih</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->tanggal }}</td>
                                    <td>{{ optional($transaksi->petani)->nama ?? '-' }}</td>
                                    <td>{{ $transaksi->berat_tbs_a ?? 0 }} Kg</td>
                                    <td>{{ $transaksi->berat_tbs_b ?? 0 }} Kg</td>
                                    <td>{{ $transaksi->berat_brondol ?? 0 }} Kg</td>
                                    <td>{{ ucfirst($transaksi->mutu_buah_a) }}</td>
                                    <td>{{ ucfirst($transaksi->mutu_buah_b) }}</td>
                                    <td>Rp {{ number_format($transaksi->total_bersih, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('agen.transaksi.nota', $transaksi->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Lihat Nota
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection