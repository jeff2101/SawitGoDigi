@extends('layouts.admin.app')

@section('title', 'Edit FAQ')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit FAQ</h1>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit FAQ</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- PERTANYAAN --}}
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="text" name="pertanyaan" id="pertanyaan"
                                    class="form-control @error('pertanyaan') is-invalid @enderror"
                                    value="{{ old('pertanyaan', $faq->pertanyaan) }}">
                                @error('pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- JAWABAN --}}
                            <div class="form-group">
                                <label for="jawaban">Jawaban</label>
                                <textarea name="jawaban" id="jawaban" rows="4"
                                    class="form-control @error('jawaban') is-invalid @enderror">{{ old('jawaban', $faq->jawaban) }}</textarea>
                                @error('jawaban')
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
                        <h6 class="m-0 font-weight-bold text-primary">Preview</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Pertanyaan:</strong></p>
                        <p>{{ $faq->pertanyaan }}</p>
                        <hr>
                        <p class="mb-1"><strong>Jawaban:</strong></p>
                        <div style="font-size: 0.9rem;">
                            {!! nl2br(e($faq->jawaban)) !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection