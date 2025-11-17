@extends('layouts.agen.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Detail Pemesanan</h1>

        <div class="card shadow">
            <div class="card-body">
                <ul>
                    <li><strong>Nama Petani:</strong> {{ $pemesanan->petani->nama ?? '-' }}</li>
                    <li><strong>Lokasi Jemput:</strong> {{ $pemesanan->lokasi_jemput }}</li>
                    <li><strong>Estimasi Bobot:</strong> {{ $pemesanan->bobot_estimasi }} Kg</li>
                    <li><strong>Jenis:</strong> {{ $pemesanan->jenis_pemesanan }}</li>
                    <li><strong>Tanggal:</strong> {{ $pemesanan->tanggal_pemesanan }}</li>
                    <li><strong>Status:</strong> <span class="badge badge-warning">{{ $pemesanan->status_pemesanan }}</span>
                    </li>
                </ul>

                <form action="{{ route('agen.pemesanan.assign', $pemesanan->id) }}" method="POST">
                    @csrf
                    <div class="form-group mt-4">
                        <label for="id_supir">Pilih Supir</label>
                        <select name="id_supir" id="id_supir" class="form-control" required>
                            <option value="">-- Pilih Supir --</option>
                            @foreach($supirs as $supir)
                                <option value="{{ $supir->id }}">{{ $supir->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Lanjutkan</button>
                </form>
            </div>
        </div>
    </div>
@endsection