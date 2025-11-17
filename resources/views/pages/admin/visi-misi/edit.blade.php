@extends('layouts.admin.app') {{-- sesuaikan dengan layout admin kamu --}}

@section('title', 'Visi & Misi')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Halaman Visi &amp; Misi</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary">Edit Visi &amp; Misi</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.visimisi.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- VISI --}}
                            <div class="form-group">
                                <label for="visi">Visi</label>
                                <textarea name="visi" id="visi" rows="4"
                                    class="form-control @error('visi') is-invalid @enderror"
                                    placeholder="Tuliskan visi utama">{{ old('visi', $visiMisi->visi) }}</textarea>
                                @error('visi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- MISI --}}
                            <div class="form-group">
                                <label for="misi">
                                    Misi
                                    <small class="text-muted d-block">
                                        *Tulis satu misi per baris, nanti di halaman depan akan tampil sebagai list
                                        poin-poin.
                                    </small>
                                </label>
                                <textarea name="misi" id="misi" rows="6"
                                    class="form-control @error('misi') is-invalid @enderror"
                                    placeholder="Contoh:&#10;Memberikan kemudahan pencatatan panen bagi petani dan agen secara digital.&#10;Menyediakan sistem transaksi yang transparan dan aman.">{{ old('misi', $visiMisi->misi) }}</textarea>
                                @error('misi')
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

            {{-- Preview --}}
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Preview Singkat</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Visi:</strong></p>
                        <div style="font-size: 0.95rem; text-align: justify;">
                            {!! nl2br(e($visiMisi->visi)) !!}
                        </div>

                        <hr>

                        <p class="mb-1"><strong>Misi (poin-poin):</strong></p>
                        @php
                            $misiItems = preg_split("/\r\n|\n|\r/", $visiMisi->misi ?? '');
                          @endphp
                        @if(!empty($misiItems))
                            <ul style="padding-left: 1.2rem; font-size: 0.9rem;">
                                @foreach($misiItems as $item)
                                    @if(trim($item) !== '')
                                        <li>{{ $item }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Belum ada misi yang diisi.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection