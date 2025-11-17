@extends('layouts.agen.app')

@section('content')
<div class="container">
    <h1>Tambah Harga Jual</h1>

    <form action="{{ route('agen.hargajual.store') }}" method="POST">
        @csrf

        <input type="hidden" id="agen_id" name="agen_id" value="{{ auth()->guard('agen')->user()->id }}">


        <div class="mb-3">
            <label for="harga_tbs" class="form-label">Harga TBS</label>
            <input type="number" step="0.01" class="form-control @error('harga_tbs') is-invalid @enderror" id="harga_tbs" name="harga_tbs" value="{{ old('harga_tbs') }}" required>
            @error('harga_tbs')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="harga_brondol" class="form-label">Harga Brondol</label>
            <input type="number" step="0.01" class="form-control @error('harga_brondol') is-invalid @enderror" id="harga_brondol" name="harga_brondol" value="{{ old('harga_brondol') }}">
            @error('harga_brondol')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="waktu_ditetapkan" class="form-label">Waktu Ditetapkan</label>
            <input type="datetime-local" class="form-control @error('waktu_ditetapkan') is-invalid @enderror" id="waktu_ditetapkan" name="waktu_ditetapkan" value="{{ old('waktu_ditetapkan') }}">
            @error('waktu_ditetapkan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan">{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('agen.hargajual.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
