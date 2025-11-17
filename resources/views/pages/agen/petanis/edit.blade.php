@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Petani</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('agen.petanis.update', ['id' => $petani->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $petani->nama }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $petani->email }}" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required>{{ $petani->alamat }}</textarea>
                </div>

                <div class="form-group">
                    <label for="kontak">No HP</label>
                    <input type="text" name="kontak" class="form-control" value="{{ $petani->kontak }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('agen.petanis.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
