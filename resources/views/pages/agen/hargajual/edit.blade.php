@extends('layouts.agen.app')

@section('content')
<div class="container">
    <h1>Edit Harga Jual</h1>

    <form action="{{ route('agen.hargajual.update', $hargaJual->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="agen_id" class="form-label">Agen</label>
            <input type="number" class="form-control @error('agen_id') is-invalid @enderror" id="agen_id" name="agen_id" value="{{ old('agen_id', $hargaJual->agen_id) }}" required>
            @error('agen_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="harga_tbs" class="form-label">Harga TBS</label>
            <input type="number" step="0.01" class="form-control @error('harga_tbs') is-invalid @enderror" id="harga_tbs" name="harga_tbs" value="{{ old('harga_tbs', $hargaJual->harga_tbs) }}" required>
            @error('harga_tbs')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="harga_brondol" class="form-label">Harga Brondol</label>
            <input type="number" step="0.01" class="form-control @error('harga_brondol') is-invalid @enderror" id="harga_brondol" name="harga_brondol" value="{{ old('harga_brondol', $hargaJual->harga_brondol) }}">
            @error('harga_brondol')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="waktu_ditetapkan" class="form-label">Waktu Ditetapkan</label>
            <input type="datetime-local" class="form-control @error('waktu_ditetapkan') is-invalid @enderror" id="waktu_ditetapkan" name="waktu_ditetapkan" value="{{ old('waktu_ditetapkan', $hargaJual->waktu_ditetapkan ? $hargaJual->waktu_ditetapkan->format('Y-m-d\TH:i') : '') }}">
            @error('waktu_ditetapkan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan">{{ old('catatan', $hargaJual->catatan) }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('agen.hargajual.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
