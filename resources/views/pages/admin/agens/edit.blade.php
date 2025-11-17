@extends('layouts.admin.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Agen</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.agens.update', ['id' => $agen->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="id_usaha">Pilih Usaha</label>
                    <select name="id_usaha" class="form-control" required>
                        <option value="">-- Pilih Usaha --</option>
                        @foreach ($usahas as $usaha)
                            <option value="{{ $usaha->id }}" {{ $agen->id_usaha == $usaha->id ? 'selected' : '' }}>
                                {{ $usaha->nama_usaha }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $agen->nama }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $agen->email }}" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required>{{ $agen->alamat }}</textarea>
                </div>

                <div class="form-group">
                    <label for="kontak">No HP</label>
                    <input type="text" name="kontak" class="form-control" value="{{ $agen->kontak }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.agens.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
