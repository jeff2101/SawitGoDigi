@extends('layouts.petani.app')

@section('content')
    <div class="container">
        <h1>Edit Lahan</h1>

        <form action="{{ route('petani.lahan.update', $lahan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lahan</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                    value="{{ old('nama', $lahan->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi"
                    value="{{ old('lokasi', $lahan->lokasi) }}" required>
                @error('lokasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="luas" class="form-label">Luas (ha)</label>
                <input type="number" step="0.01" class="form-control @error('luas') is-invalid @enderror" id="luas"
                    name="luas" value="{{ old('luas', $lahan->luas) }}" required>
                @error('luas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input latitude dan longitude disembunyikan -->
            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $lahan->latitude) }}" required>
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $lahan->longitude) }}" required>

            <div class="mb-3">
                <label class="form-label">Pilih Lokasi di Peta (Klik atau Cari Lokasi)</label>
                <div id="map" style="height: 400px; border: 1px solid #ccc;"></div>
                @error('latitude')
                    <div class="text-danger">Latitude harus diisi (klik di peta atau cari lokasi)</div>
                @enderror
                @error('longitude')
                    <div class="text-danger">Longitude harus diisi (klik di peta atau cari lokasi)</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('petani.lahan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    {{-- Load CSS dan JS Leaflet dari CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Load CSS dan JS Leaflet Control Geocoder --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var defaultLat = parseFloat("{{ old('latitude', $lahan->latitude ?? '-6.200000') }}");
            var defaultLng = parseFloat("{{ old('longitude', $lahan->longitude ?? '106.816666') }}");
            var defaultZoom = 12;

            var map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            // Jika sudah ada koordinat, pasang marker
            if (defaultLat && defaultLng && defaultLat !== 0 && defaultLng !== 0) {
                marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
                // Saat marker drag, update input lat & lng
                marker.on('dragend', function (e) {
                    var pos = e.target.getLatLng();
                    updateLatLngInputs(pos);
                });
            }

            function updateLatLngInputs(latlng) {
                document.getElementById('latitude').value = latlng.lat.toFixed(8);
                document.getElementById('longitude').value = latlng.lng.toFixed(8);
            }

            function onMapClick(e) {
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                    marker.on('dragend', function (e) {
                        var pos = e.target.getLatLng();
                        updateLatLngInputs(pos);
                    });
                }
                updateLatLngInputs(e.latlng);
            }

            map.on('click', onMapClick);

            // Tambahkan Control Geocoder (search box)
            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            })
                .on('markgeocode', function (e) {
                    var latlng = e.geocode.center;
                    map.setView(latlng, 16);

                    if (marker) {
                        marker.setLatLng(latlng);
                    } else {
                        marker = L.marker(latlng, { draggable: true }).addTo(map);
                        marker.on('dragend', function (e) {
                            var pos = e.target.getLatLng();
                            updateLatLngInputs(pos);
                        });
                    }
                    updateLatLngInputs(latlng);
                })
                .addTo(map);
        });
    </script>
@endsection