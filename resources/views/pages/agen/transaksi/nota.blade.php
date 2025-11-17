@extends('layouts.agen.app')

@section('content')
    <div class="container mt-4" id="nota">
        <h4 class="mb-3">Nota Transaksi</h4>

        <table class="table table-bordered">
            <tr>
                <th>No Transaksi</th>
                <td>#{{ $transaksi->id }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
            </tr>
            <tr>
                <th>Nama Agen</th>
                <td>{{ $transaksi->agen->nama }}</td>
            </tr>
            <tr>
                <th>Nama Petani</th>
                <td>{{ $transaksi->petani->nama ?? '-' }}</td>
            </tr>
        </table>

        <h5 class="mt-4">Detail Perhitungan Per Jenis</h5>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Jenis</th>
                    <th>Berat Awal</th>
                    <th>Potongan Alas</th>
                    <th>Potongan %</th>
                    <th>Berat Bersih</th>
                    <th>Harga/Kg</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $potonganAlas = $transaksi->potongan_alas_timbang ?? 0;
                    $potonganPersen = $transaksi->potongan_persen ?? 0;

                    $bersihA = max(0, ($transaksi->berat_tbs_a - $potonganAlas) * (1 - $potonganPersen / 100));
                    $subtotalA = $bersihA * $transaksi->harga_tbs_a;

                    $bersihB = max(0, ($transaksi->berat_tbs_b - $potonganAlas) * (1 - $potonganPersen / 100));
                    $subtotalB = $bersihB * $transaksi->harga_tbs_b;

                    $bersihBrondol = max(0, ($transaksi->berat_brondol - $potonganAlas) * (1 - $potonganPersen / 100));
                    $subtotalBrondol = $bersihBrondol * $transaksi->harga_brondol;
                @endphp

                <tr>
                    <td>Buah A ({{ ucfirst($transaksi->mutu_buah_a) }})</td>
                    <td>{{ number_format($transaksi->berat_tbs_a, 2) }} Kg</td>
                    <td>{{ $potonganAlas }} Kg</td>
                    <td>{{ $potonganPersen }}%</td>
                    <td>{{ number_format($bersihA, 2) }} Kg</td>
                    <td>Rp {{ number_format($transaksi->harga_tbs_a, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotalA, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Buah B ({{ ucfirst($transaksi->mutu_buah_b) }})</td>
                    <td>{{ number_format($transaksi->berat_tbs_b, 2) }} Kg</td>
                    <td>{{ $potonganAlas }} Kg</td>
                    <td>{{ $potonganPersen }}%</td>
                    <td>{{ number_format($bersihB, 2) }} Kg</td>
                    <td>Rp {{ number_format($transaksi->harga_tbs_b, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotalB, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Brondol</td>
                    <td>{{ number_format($transaksi->berat_brondol, 2) }} Kg</td>
                    <td>{{ $potonganAlas }} Kg</td>
                    <td>{{ $potonganPersen }}%</td>
                    <td>{{ number_format($bersihBrondol, 2) }} Kg</td>
                    <td>Rp {{ number_format($transaksi->harga_brondol, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($subtotalBrondol, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered mt-4">
            <tr class="table-success">
                <th>Total Bersih Dibayar</th>
                <td><strong>Rp {{ number_format($transaksi->total_bersih, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
            </tr>
        </table>

        <div class="text-end">
            <button class="btn btn-primary" onclick="window.print()">🖨 Cetak Nota</button>
            <a href="{{ route('agen.transaksi.index') }}" class="btn btn-secondary">&larr; Kembali</a>
        </div>
    </div>
@endsection