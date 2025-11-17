@extends('layouts.admin.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Usaha</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.usahas.update', ['id' => $usaha->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_usaha">Nama Usaha</label>
                    <input type="text" class="form-control" id="nama_usaha" name="nama_usaha"
                        value="{{ old('nama_usaha', $usaha->nama_usaha) }}" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat"
                        rows="3">{{ old('alamat', $usaha->alamat) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" class="form-control" id="kontak" name="kontak"
                        value="{{ old('kontak', $usaha->kontak) }}">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('admin.usahas.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection