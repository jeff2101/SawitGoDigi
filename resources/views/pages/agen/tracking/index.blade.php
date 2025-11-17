@extends('layouts.agen.app')

@section('title', 'Tracking Supir')

@section('content')
    <div class="container">
        <h3 class="mb-4">🗺️ Tracking Supir Aktif</h3>

        {{-- Debug info --}}
        <div class="alert alert-info mb-3">
            <strong>Debug Info:</strong><br>
            Total Supir: <span id="total-supirs">-</span><br>
            Supir dengan lokasi: <span id="supirs-with-location">-</span>
        </div>

        {{-- Peta --}}
        <div id="map" class="position-relative"
            style="height: 600px; width: 100%; border: 1px solid #ccc; border-radius: 10px;"></div>
    </div>
@endsection

@push('styles')
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const supirs = @json($supirs ?? []);

            // Inisialisasi peta Indonesia tengah
            const map = L.map('map').setView([-2.5489, 118.0149], 5);

            // Hitung debug info
            document.getElementById('total-supirs').textContent = supirs.length;
            const supirsWithLocation = supirs.filter(s => s.latitude && s.longitude);
            document.getElementById('supirs-with-location').textContent = supirsWithLocation.length;

            // Tambahkan tile OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            // Tambahkan geocoder (search box)
            L.Control.geocoder({
                defaultMarkGeocode: false
            })
                .on('markgeocode', function (e) {
                    const latlng = e.geocode.center;
                    map.setView(latlng, 13);
                })
                .addTo(map);

            // Marker icon custom (opsional)
            const supirIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Tambahkan semua marker supir
            const group = [];

            supirsWithLocation.forEach(s => {
                const lat = parseFloat(s.latitude);
                const lng = parseFloat(s.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const marker = L.marker([lat, lng], { icon: supirIcon }).addTo(map)
                        .bindPopup(`
                                <div>
                                    <strong>${s.nama ?? 'Supir Tanpa Nama'}</strong><br>
                                    Update Terakhir: ${s.last_updated_location ?? 'Tidak diketahui'}<br>
                                    Lat: ${lat}, Lng: ${lng}
                                </div>
                            `);
                    group.push(marker);
                }
            });

            // Zoom agar semua marker terlihat
            if (group.length > 0) {
                const groupLayer = L.featureGroup(group);
                map.fitBounds(groupLayer.getBounds().pad(0.2));

                // Perbaikan tampilan bila peta awal kosong
                setTimeout(() => map.invalidateSize(), 300);
            }
        });

        // Jika halaman resize
        window.addEventListener('resize', function () {
            if (typeof map !== 'undefined') {
                setTimeout(() => map.invalidateSize(), 300);
            }
        });
    </script>
@endpush