@extends('layouts.admin.app')

@section('title', 'FAQ')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pertanyaan yang Sering Diajukan (FAQ)</h1>
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah FAQ
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar FAQ</h6>
            </div>
            <div class="card-body">
                @if($faqs->isEmpty())
                    <p class="mb-0 text-muted">Belum ada FAQ yang ditambahkan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faqs as $index => $faq)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $faq->pertanyaan }}</td>
                                        <td style="max-width: 400px;">
                                            {{ \Illuminate\Support\Str::limit($faq->jawaban, 120) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-warning mb-1">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection