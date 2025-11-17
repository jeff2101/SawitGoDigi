@extends('layouts.petani.app')

@section('content')
    <div class="container-fluid">

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Alert error --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow border-0 mb-4">
            <div class="row no-gutters">
                {{-- FOTO & NAMA --}}
                <div class="col-md-4 text-center text-white" style="background-color: #1B4D3E; padding: 40px;">
                    @if($petani->foto && file_exists(public_path('img/' . $petani->foto)))
                        <img src="{{ asset('img/' . $petani->foto) }}?v={{ time() }}" alt="Foto Profil"
                            class="img-fluid rounded-circle mb-3"
                            style="width: 220px; height: 220px; object-fit: cover; border: 5px solid #fff;">
                    @else
                        <img src="{{ asset('img/default-profile.png') }}" alt="Default" class="img-fluid rounded-circle mb-3"
                            style="width: 220px; height: 220px; object-fit: cover; border: 5px solid #fff;">
                    @endif
                    <h4 class="font-weight-bold">{{ $petani->nama }}</h4>
                    <p class="mb-0">Petani Sawit</p>
                </div>

                {{-- INFORMASI & FORM --}}
                <div class="col-md-8 p-4 bg-white">
                    {{-- DATA --}}
                    <h5 class="text-muted">Halo, Selamat Datang</h5>
                    <h3 class="font-weight-bold text-success">{{ strtoupper($petani->nama) }}</h3>

                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 120px;">Alamat</th>
                            <td>{{ $petani->alamat ?? 'Belum ada informasi' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $petani->email }}</td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $petani->kontak ?? 'Belum ada informasi' }}</td>
                        </tr>
                    </table>

                    {{-- BUTTON TOGGLE --}}
                    <button class="btn btn-success mb-3" id="editProfileBtn">Edit Profil</button>

                    {{-- FORM EDIT PROFIL --}}
                    <form action="{{ route('petani.profile.update') }}" method="POST" enctype="multipart/form-data"
                        id="editProfileForm" style="display: none;">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $petani->nama) }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control"
                                value="{{ old('alamat', $petani->alamat) }}">
                        </div>

                        <div class="form-group">
                            <label for="kontak">No HP</label>
                            <input type="text" name="kontak" class="form-control"
                                value="{{ old('kontak', $petani->kontak) }}">
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto Profil (Max 5MB)</label>
                            <input type="file" name="foto" class="form-control-file" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" id="cancelEditBtn">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- TOGGLE SCRIPT --}}
    <script>
        document.getElementById('editProfileBtn').addEventListener('click', function () {
            document.getElementById('editProfileForm').style.display = 'block';
            this.style.display = 'none';
        });

        document.getElementById('cancelEditBtn').addEventListener('click', function () {
            document.getElementById('editProfileForm').style.display = 'none';
            document.getElementById('editProfileBtn').style.display = 'inline-block';
        });
    </script>
@endsection