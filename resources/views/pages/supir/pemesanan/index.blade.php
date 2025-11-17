@extends('layouts.supir.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tugas Jemput</h1>

        {{-- Notifikasi status --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Info lokasi --}}
        <div class="alert alert-info">
            🛰️ Lokasi Anda sedang dipantau dan dikirim otomatis ke server setiap 30 detik.
            <br>
            📍 Posisi Anda saat ini: <span id="lokasi-info">-</span>
        </div>

        {{-- Tabel pemesanan --}}
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Petani</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Maps</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemesanan as $pemesananItem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pemesananItem->petani->nama ?? '-' }}</td>
                                    <td>{{ $pemesananItem->lokasi_jemput }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pemesananItem->tanggal_pemesanan)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge
                                                            @if($pemesananItem->status_pemesanan == 'pending') bg-warning
                                                            @elseif($pemesananItem->status_pemesanan == 'proses') bg-info
                                                            @elseif($pemesananItem->status_pemesanan == 'dijemput') bg-primary
                                                            @elseif($pemesananItem->status_pemesanan == 'selesai') bg-success
                                                            @elseif($pemesananItem->status_pemesanan == 'dibatalkan') bg-danger
                                                            @endif">
                                            {{ ucfirst($pemesananItem->status_pemesanan) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($pemesananItem->latitude && $pemesananItem->longitude)
                                            <a href="https://www.google.com/maps?q={{ $pemesananItem->latitude }},{{ $pemesananItem->longitude }}"
                                                target="_blank" class="btn btn-sm btn-info">
                                                Lihat di Google Maps
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('supir.pemesanan.show', $pemesananItem->id) }}"
                                            class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada tugas saat ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pemesanan->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("📡 Pelacakan lokasi aktif...");

            const lokasiInfoEl = document.getElementById('lokasi-info');

            if ("geolocation" in navigator) {
                function updateLocation(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    lokasiInfoEl.textContent = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;

                    fetch("{{ route('supir.update-lokasi') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            latitude: lat,
                            longitude: lng
                        })
                    })
                        .then(res => {
                            if (res.status === 204) {
                                console.log("⛔ Tidak ada tugas aktif. Lokasi tidak dikirim.");
                                return;
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (data) {
                                console.log("✅ Lokasi supir diperbarui:", data);
                            }
                        })
                        .catch(err => console.error("❌ Gagal mengirim lokasi:", err));
                }

                function handleError(error) {
                    console.error("❌ Lokasi tidak dapat diperbarui:", error.message);
                }

                // Kirim saat load pertama
                navigator.geolocation.getCurrentPosition(updateLocation, handleError);

                // Kirim ulang setiap 30 detik jika ada tugas aktif
                setInterval(() => {
                    navigator.geolocation.getCurrentPosition(updateLocation, handleError);
                }, 30000);
            } else {
                console.warn("❌ Geolocation tidak didukung oleh browser ini.");
            }
        });
    </script>
@endpush