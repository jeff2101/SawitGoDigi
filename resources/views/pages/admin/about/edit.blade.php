@extends('layouts.admin.app') {{-- sesuaikan dengan layout admin kamu --}}

@section('title', 'Tentang Kami')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Halaman Tentang Kami</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Konten Tentang Kami</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.about.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" id="judul"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul', $about->judul) }}" placeholder="Judul section Tentang Kami">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="6"
                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                    placeholder="Deskripsi tentang aplikasi / usaha">{{ old('deskripsi', $about->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Preview Singkat</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Judul saat ini:</strong></p>
                        <p>{{ $about->judul }}</p>
                        <hr>
                        <p class="mb-1"><strong>Deskripsi:</strong></p>
                        <div style="max-height: 200px; overflow-y: auto; font-size: 0.9rem; text-align: justify;">
                            {!! nl2br(e($about->deskripsi)) !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection