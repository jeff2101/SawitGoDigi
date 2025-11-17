@extends('layouts.petani.app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4 text-gray-800">Ubah Password</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow border-0" style="max-width: 600px;">
            <div class="card-body">
                <form action="{{ route('petani.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="6">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Ulangi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required minlength="6">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                    <a href="{{ route('petani.profile') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection