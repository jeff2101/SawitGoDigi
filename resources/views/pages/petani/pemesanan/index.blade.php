@extends('layouts.petani.app')

@section('title', 'Daftar Pemesanan')

@section('content')
    <div class="container mt-4">
        <h4>Daftar Pemesanan Saya</h4>

        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('petani.pemesanan.create') }}" class="btn btn-primary">+ Buat Pemesanan Baru</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Bobot Estimasi (kg)</th>
                        <th>Lokasi Jemput</th>
                        <th>Status</th>
                        <th>Maps</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesanans as $pemesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->format('d-m-Y') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $pemesanan->jenis_pemesanan)) }}</td>
                            <td>{{ $pemesanan->bobot_estimasi }} kg</td>
                            <td>{{ $pemesanan->lokasi_jemput }}</td>
                            <td>
                                <span class="badge
                                            @if($pemesanan->status_pemesanan == 'pending') bg-warning
                                            @elseif($pemesanan->status_pemesanan == 'proses') bg-info
                                            @elseif($pemesanan->status_pemesanan == 'dijemput') bg-primary
                                            @elseif($pemesanan->status_pemesanan == 'selesai') bg-success
                                            @elseif($pemesanan->status_pemesanan == 'dibatalkan') bg-danger
                                            @endif">
                                    {{ ucfirst($pemesanan->status_pemesanan) }}
                                </span>
                            </td>
                            <td>
                                @if($pemesanan->latitude && $pemesanan->longitude)
                                    <a href="https://www.google.com/maps?q={{ $pemesanan->latitude }},{{ $pemesanan->longitude }}"
                                        target="_blank" class="btn btn-sm btn-info">
                                        Lihat di Google Maps
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(in_array($pemesanan->status_pemesanan, ['pending', 'proses']))
                                    <a href="{{ route('petani.pemesanan.edit', $pemesanan->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('petani.pemesanan.batal', $pemesanan->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-danger">Batalkan</button>
                                    </form>
                                @endif

                                @if($pemesanan->status_pemesanan === 'dibatalkan')
                                    <form action="{{ route('petani.pemesanan.destroy', $pemesanan->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus permanen pemesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pemesanans->links() }}
        </div>
    </div>
@endsection