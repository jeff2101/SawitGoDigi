@extends('layouts.supir.app')

@section('title', 'Track Record')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Track Record Pemesanan</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                @if($trackRecords->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petani</th>
                                    <th>Lokasi Jemput</th>
                                    <th>Tanggal</th>
                                    <th>Bobot Estimasi (kg)</th>
                                    <th>Status</th>
                                    <th>Maps</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trackRecords as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->petani->nama ?? '-' }}</td>
                                        <td>{{ $record->lokasi_jemput }}</td>
                                        <td>{{ \Carbon\Carbon::parse($record->tanggal_pemesanan)->format('d-m-Y') }}</td>
                                        <td>{{ number_format($record->bobot_estimasi, 2, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $record->status_pemesanan === 'selesai' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($record->status_pemesanan) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($record->latitude && $record->longitude)
                                                <a href="https://www.google.com/maps?q={{ $record->latitude }},{{ $record->longitude }}"
                                                    target="_blank" class="btn btn-sm btn-info">
                                                    Lihat di Google Maps
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">Belum ada track record.</p>
                @endif
            </div>
        </div>
    </div>
@endsection