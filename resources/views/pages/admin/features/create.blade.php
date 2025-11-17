@extends('layouts.admin.app')

@section('title', 'Tambah Fitur')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Fitur Baru</h1>
            <a href="{{ route('admin.features.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Fitur</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $iconOptions = [
                                'bi bi-pencil-square' => 'Pencatatan / Input Data',
                                'bi bi-cloud-upload' => 'Penyimpanan Online',
                                'bi bi-receipt-cutoff' => 'Nota / Kwitansi',
                                'bi bi-people' => 'Petani & Agen',
                                'bi bi-bar-chart-line' => 'Statistik & Grafik',
                                'bi bi-cash-stack' => 'Keuangan / Upah',
                                'bi bi-phone' => 'Akses HP & Web',
                                'bi bi-lock' => 'Keamanan Data',
                            ];

                            $selectedIcon = old('icon', 'bi bi-pencil-square');
                        @endphp

                        <form action="{{ route('admin.features.store') }}" method="POST">
                            @csrf

                            {{-- ICON (dropdown + preview) --}}
                            <div class="form-group">
                                <label for="icon">
                                    Icon Fitur
                                    <small class="text-muted d-block">
                                        Pilih icon, admin tidak perlu menghafal class-nya
                                    </small>
                                </label>

                                <div class="d-flex align-items-center">
                                    <select name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror"
                                        style="max-width: 320px;">
                                        @foreach($iconOptions as $class => $label)
                                            <option value="{{ $class }}" {{ $selectedIcon === $class ? 'selected' : '' }}>
                                                {{ $label }} ({{ $class }})
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Preview icon --}}
                                    <div class="ml-3 text-center">
                                        <div>Preview:</div>
                                        <div style="font-size: 2rem;">
                                            <i id="icon-preview" class="{{ $selectedIcon }}"></i>
                                        </div>
                                    </div>
                                </div>

                                @error('icon')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JUDUL --}}
                            <div class="form-group">
                                <label for="judul">Judul Fitur</label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}"
                                    placeholder="misal: Pencatatan Panen Mudah">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi (opsional)</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    placeholder="Deskripsi singkat fitur (boleh dikosongkan)">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Sidebar info --}}
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Petunjuk Icon</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            Icon di atas menggunakan <strong>Bootstrap Icons</strong>.
                        </p>
                        <p class="mb-2">
                            Beberapa contoh icon yang tersedia:
                        </p>
                        <ul>
                            <li><code>bi bi-pencil-square</code> &mdash; Pencatatan</li>
                            <li><code>bi bi-cloud-upload</code> &mdash; Penyimpanan Online</li>
                            <li><code>bi bi-receipt-cutoff</code> &mdash; Nota / Kwitansi</li>
                            <li><code>bi bi-people</code> &mdash; Petani &amp; Agen</li>
                            <li><code>bi bi-bar-chart-line</code> &mdash; Statistik</li>
                            <li><code>bi bi-cash-stack</code> &mdash; Keuangan</li>
                            <li><code>bi bi-phone</code> &mdash; Mobile</li>
                            <li><code>bi bi-lock</code> &mdash; Keamanan</li>
                        </ul>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">
                            Jika nanti ingin menambah jenis icon lain, cukup tambahkan ke daftar
                            <code>$iconOptions</code> di atas.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Script kecil untuk update preview icon --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.getElementById('icon');
            var preview = document.getElementById('icon-preview');

            if (select && preview) {
                select.addEventListener('change', function () {
                    preview.className = this.value;
                });
            }
        });
    </script>
@endsection