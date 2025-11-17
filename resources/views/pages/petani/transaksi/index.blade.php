@extends('layouts.petani.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Riwayat Transaksi Saya</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Berat TBS</th>
                                <th>Berat Brondol</th>
                                <th>Mutu</th>
                                <th>Total Bersih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $transaksi)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $transaksi->berat_tbs }} Kg</td>
                                    <td>{{ $transaksi->berat_brondol }} Kg</td>
                                    <td>{{ ucfirst($transaksi->mutu_buah) }}</td>
                                    <td>Rp {{ number_format($transaksi->total_bersih, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total Keseluruhan:</th>
                                <th>Rp {{ number_format($totalBersih, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection