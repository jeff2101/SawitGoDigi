@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Tambah Petani</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('agen.petanis.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="kontak">No HP</label>
                    <input type="text" name="kontak" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('agen.petanis.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
