@extends('layouts.supir.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Detail Tugas</h1>

        <div class="card shadow">
            <div class="card-body">
                <ul>
                    <li><strong>Petani:</strong> {{ $pemesanan->petani->nama ?? '-' }}</li>
                    <li><strong>Lokasi Jemput:</strong> {{ $pemesanan->lokasi_jemput }}</li>
                    <li><strong>Bobot Estimasi:</strong> {{ $pemesanan->bobot_estimasi }} Kg</li>
                    <li><strong>Jenis:</strong> {{ $pemesanan->jenis_pemesanan }}</li>
                    <li><strong>Status:</strong> {{ $pemesanan->status_pemesanan }}</li>
                    @if($pemesanan->google_maps_url)
                        <li><a href="{{ $pemesanan->google_maps_url }}" target="_blank"
                                class="btn btn-sm btn-success mt-2">Lihat di Google Maps</a></li>
                    @endif
                </ul>

                <form action="{{ route('supir.pemesanan.updateStatus', $pemesanan->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="form-group">
                        <label>Ubah Status:</label>
                        <select name="status_pemesanan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="dijemput" {{ $pemesanan->status_pemesanan == 'dijemput' ? 'selected' : '' }}>
                                Dijemput</option>
                            <option value="proses_transaksi" {{ $pemesanan->status_pemesanan == 'proses_transaksi' ? 'selected' : '' }}>Sampai ke Agen (Proses Transaksi)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection