@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Tambah Supir</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('agen.supirs.store') }}" method="POST">
                @csrf

                {{-- Agen ID tersembunyi --}}
                <input type="hidden" name="agen_id" value="{{ auth()->user()->id }}">

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label for="jenis_kendaraan">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password <small class="text-muted">(minimal 6 karakter)</small></label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('agen.supirs.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection