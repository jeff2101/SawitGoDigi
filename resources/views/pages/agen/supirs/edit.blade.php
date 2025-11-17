@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Supir</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('agen.supirs.update', ['id' => $supir->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $supir->nama }}" required>
                </div>

                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="{{ $supir->kontak }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $supir->email }}">
                </div>

                <div class="form-group">
                    <label for="jenis_kendaraan">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" value="{{ $supir->jenis_kendaraan }}">
                </div>

                <div class="form-group">
                    <label for="password">Password <small class="text-muted">(kosongkan jika tidak ingin
                            diubah)</small></label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('agen.supirs.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection