@extends('layouts.supir.app')

@section('content')
    <div class="container-fluid">
        <!-- Pesan sukses -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Pesan error -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4 border-0">
            <div class="row no-gutters" style="min-height: 100%;">
                <!-- KIRI: Foto & Nama -->
                <div class="col-md-4 text-center text-white" style="background-color: #1B4D3E; padding: 40px;">
                    @if($supir->foto && file_exists(public_path('img/' . $supir->foto)))
                        <img src="{{ asset('img/' . $supir->foto) }}?v={{ time() }}" alt="Foto Profil"
                            class="img-fluid rounded-circle mb-3"
                            style="width: 250px; height: 250px; object-fit: cover; border: 5px solid #fff;">
                    @else
                        <img src="{{ asset('img/default-profile.png') }}" alt="Default" class="img-fluid rounded-circle mb-3"
                            style="width: 250px; height: 250px; object-fit: cover; border: 5px solid #fff;">
                    @endif
                    <h4 class="font-weight-bold mb-1">{{ $supir->nama }}</h4>
                    <p class="mb-0">Supir</p>
                </div>

                <!-- KANAN: Informasi Profil -->
                <div class="col-md-8" style="background-color: #ffffff; padding: 40px;">
                    <h5 class="text-muted">Halo &amp; Selamat Datang</h5>
                    <h3 class="font-weight-bold mb-3 text-success">{{ strtoupper($supir->nama) }}</h3>

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 120px;">Email</th>
                                <td>{{ $supir->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Kontak</th>
                                <td>{{ $supir->kontak ?? 'Belum ada informasi' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Jenis Kendaraan</th>
                                <td>{{ $supir->jenis_kendaraan ?? 'Belum ada informasi' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Tombol Edit -->
                    <button class="btn btn-success" id="editProfileBtn">Edit Profil</button>

                    <!-- Form Edit -->
                    <form action="{{ route('supir.profile.update') }}" method="POST" enctype="multipart/form-data"
                        id="editProfileForm" style="display:none; margin-top:30px;">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                value="{{ old('nama', $supir->nama) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <p class="form-control-plaintext text-muted">{{ $supir->email }}</p>
                        </div>

                        <div class="form-group">
                            <label for="kontak">No HP</label>
                            <input type="text" class="form-control" name="kontak" id="kontak"
                                value="{{ old('kontak', $supir->kontak) }}">
                        </div>

                        <div class="form-group">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" name="jenis_kendaraan" id="jenis_kendaraan"
                                value="{{ old('jenis_kendaraan', $supir->jenis_kendaraan) }}">
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto Profil (Max 5 MB)</label>
                            <input type="file" class="form-control-file" name="foto" id="foto" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" id="cancelEditBtn">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script toggle form -->
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