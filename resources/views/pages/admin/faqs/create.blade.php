@extends('layouts.admin.app')

@section('title', 'Tambah FAQ')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah FAQ</h1>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form FAQ</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.faqs.store') }}" method="POST">
                            @csrf

                            {{-- PERTANYAAN --}}
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="text" name="pertanyaan" id="pertanyaan"
                                    class="form-control @error('pertanyaan') is-invalid @enderror"
                                    value="{{ old('pertanyaan') }}"
                                    placeholder="misal: Bagaimana cara mendaftar sebagai petani atau agen?">
                                @error('pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JAWABAN --}}
                            <div class="form-group">
                                <label for="jawaban">Jawaban</label>
                                <textarea name="jawaban" id="jawaban" rows="4"
                                    class="form-control @error('jawaban') is-invalid @enderror"
                                    placeholder="Tuliskan jawaban lengkap untuk pertanyaan ini">{{ old('jawaban') }}</textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tips Pengisian</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Tulis pertanyaan dengan bahasa yang sering dipakai user.</p>
                        <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                            Jawaban boleh beberapa kalimat, tapi usahakan tetap singkat dan jelas.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection