@extends('layouts.petani.app')

@section('content')
    @php
        use Carbon\Carbon;

        // Pastikan $pemesanan->tanggal_pemesanan bisa diparse Carbon
        $tanggalPemesanan = null;
        try {
            $tanggalPemesanan = Carbon::parse($pemesanan->tanggal_pemesanan);
        } catch (\Exception $e) {
            $tanggalPemesanan = null;
        }
    @endphp

    <div class="container">
        <h1>Edit Pemesanan</h1>

        <form action="{{ route('petani.pemesanan.update', $pemesanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="id_lahan" class="form-label">Pilih Lahan (Opsional)</label>
                <select class="form-select @error('id_lahan') is-invalid @enderror" id="id_lahan" name="id_lahan">
                    <option value="">-- Tidak memilih lahan --</option>
                    @foreach($lahans as $lahan)
                        <option value="{{ $lahan->id }}" data-lokasi="{{ $lahan->lokasi }}" data-lat="{{ $lahan->latitude }}"
                            data-lng="{{ $lahan->longitude }}" {{ old('id_lahan', $pemesanan->id_lahan) == $lahan->id ? 'selected' : '' }}>
                            {{ $lahan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('id_lahan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lokasi_jemput" class="form-label">Lokasi Jemput</label>
                <input type="text" class="form-control @error('lokasi_jemput') is-invalid @enderror" id="lokasi_jemput"
                    name="lokasi_jemput" value="{{ old('lokasi_jemput', $pemesanan->lokasi_jemput) }}" required>
                @error('lokasi_jemput')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $pemesanan->latitude) }}" required>
            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $pemesanan->longitude) }}"
                required>

            <div class="mb-3">
                <label class="form-label">Pilih Titik Lokasi Jemput di Peta</label>
                <div id="map" style="height: 400px; border: 1px solid #ccc;"></div>
                @error('latitude')
                    <div class="text-danger">Latitude harus diisi</div>
                @enderror
                @error('longitude')
                    <div class="text-danger">Longitude harus diisi</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bobot_estimasi" class="form-label">Bobot Estimasi (kg)</label>
                <input type="number" class="form-control @error('bobot_estimasi') is-invalid @enderror" id="bobot_estimasi"
                    name="bobot_estimasi" value="{{ old('bobot_estimasi', $pemesanan->bobot_estimasi) }}" required min="0">
                @error('bobot_estimasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_pemesanan" class="form-label">Jenis Pemesanan</label>
                <select class="form-select @error('jenis_pemesanan') is-invalid @enderror" id="jenis_pemesanan"
                    name="jenis_pemesanan" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="buah_petani" {{ old('jenis_pemesanan', $pemesanan->jenis_pemesanan) == 'buah_petani' ? 'selected' : '' }}>Buah dari Petani</option>
                    <option value="buah_pt" {{ old('jenis_pemesanan', $pemesanan->jenis_pemesanan) == 'buah_pt' ? 'selected' : '' }}>Buah dari PT</option>
                </select>
                @error('jenis_pemesanan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control @error('tanggal_pemesanan') is-invalid @enderror"
                    id="tanggal_pemesanan" name="tanggal_pemesanan"
                    value="{{ old('tanggal_pemesanan', $tanggalPemesanan ? $tanggalPemesanan->format('Y-m-d') : '') }}"
                    required>
                @error('tanggal_pemesanan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Pemesanan</button>
            <a href="{{ route('petani.pemesanan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    {{-- Leaflet CSS dan JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Geocoder untuk pencarian lokasi --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var defaultLat = parseFloat("{{ old('latitude', $pemesanan->latitude ?? '-6.200000') }}");
            var defaultLng = parseFloat("{{ old('longitude', $pemesanan->longitude ?? '106.816666') }}");
            var defaultZoom = 12;

            var map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker;
            if (defaultLat && defaultLng && defaultLat !== 0 && defaultLng !== 0) {
                marker = L.marker([defaultLat, defaultLng]).addTo(map);
            }

            function updateLatLngInputs(latlng) {
                document.getElementById('latitude').value = latlng.lat.toFixed(8);
                document.getElementById('longitude').value = latlng.lng.toFixed(8);
            }

            map.on('click', function (e) {
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
                updateLatLngInputs(e.latlng);
            });

            L.Control.geocoder({
                defaultMarkGeocode: false
            })
                .on('markgeocode', function (e) {
                    var latlng = e.geocode.center;
                    map.setView(latlng, 16);
                    if (marker) {
                        marker.setLatLng(latlng);
                    } else {
                        marker = L.marker(latlng).addTo(map);
                    }
                    updateLatLngInputs(latlng);
                })
                .addTo(map);

            document.getElementById('id_lahan').addEventListener('change', function () {
                var selectedOption = this.options[this.selectedIndex];
                var lokasi = selectedOption.getAttribute('data-lokasi');
                var lat = selectedOption.getAttribute('data-lat');
                var lng = selectedOption.getAttribute('data-lng');

                if (lat && lng) {
                    document.getElementById('lokasi_jemput').value = lokasi || '';
                    var latNum = parseFloat(lat);
                    var lngNum = parseFloat(lng);
                    document.getElementById('latitude').value = latNum.toFixed(8);
                    document.getElementById('longitude').value = lngNum.toFixed(8);

                    var latlng = [latNum, lngNum];
                    map.setView(latlng, 16);

                    if (marker) {
                        marker.setLatLng(latlng);
                    } else {
                        marker = L.marker(latlng).addTo(map);
                    }
                }
            });
        });
    </script>
@endsection