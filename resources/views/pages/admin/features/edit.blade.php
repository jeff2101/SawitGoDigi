@extends('layouts.admin.app')

@section('title', 'Edit Fitur')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Fitur</h1>
            <a href="{{ route('admin.features.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Fitur</h6>
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

                            $selectedIcon = old('icon', $feature->icon ?? 'bi bi-pencil-square');
                        @endphp

                        <form action="{{ route('admin.features.update', $feature) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- ICON (dropdown + preview) --}}
                            <div class="form-group">
                                <label for="icon">Icon Fitur</label>

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
                                        <small class="text-muted d-block" style="font-size: 0.8rem;">
                                            Class: <code id="icon-class-text">{{ $selectedIcon }}</code>
                                        </small>
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
                                    class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul', $feature->judul) }}" placeholder="misal: Pencatatan Panen Mudah">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi (opsional)</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    placeholder="Deskripsi singkat fitur (boleh dikosongkan)">{{ old('deskripsi', $feature->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- Sidebar info --}}
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Preview Icon</h6>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-2">Icon saat ini (sesuai pilihan):</p>
                        <div style="font-size: 2rem;">
                            <i id="icon-preview-side" class="{{ $selectedIcon }}"></i>
                        </div>
                        <p class="mt-2 mb-0 text-muted" style="font-size: 0.85rem;">
                            Class: <code id="icon-class-text-side">{{ $selectedIcon }}</code>
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Script kecil untuk sinkron preview --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.getElementById('icon');
            var previewMain = document.getElementById('icon-preview');
            var previewSide = document.getElementById('icon-preview-side');
            var classTextMain = document.getElementById('icon-class-text');
            var classTextSide = document.getElementById('icon-class-text-side');

            if (select && previewMain && previewSide) {
                select.addEventListener('change', function () {
                    var val = this.value;
                    previewMain.className = val;
                    previewSide.className = val;

                    if (classTextMain) classTextMain.textContent = val;
                    if (classTextSide) classTextSide.textContent = val;
                });
            }
        });
    </script>
@endsection