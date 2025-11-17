@extends('layouts.petani.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Supir</h1>

        @if($supirs->count())
            <div class="row">
                @foreach($supirs as $supir)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                {{-- Foto Supir --}}
                                <img src="{{ $supir->foto && file_exists(public_path('img/' . $supir->foto))
                        ? asset('img/' . $supir->foto)
                        : asset('assets/img/default-user.png') }}" alt="Foto Supir"
                                    class="rounded-circle mb-3"
                                    style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ccc;">

                                {{-- Nama --}}
                                <h5 class="card-title mb-1">{{ $supir->nama }}</h5>

                                {{-- Kontak --}}
                                <p class="text-muted mb-1">{{ $supir->kontak ?? '-' }}</p>

                                {{-- Email --}}
                                <p class="text-muted small">{{ $supir->email }}</p>

                                {{-- Jenis Kendaraan --}}
                                @if($supir->jenis_kendaraan)
                                    <span class="badge bg-primary">{{ $supir->jenis_kendaraan }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Belum ada supir yang melayani Anda.</p>
        @endif
    </div>
@endsection