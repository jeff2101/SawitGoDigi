@extends('layouts.agen.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Petani</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($petanis as $petani)
                            <tr>
                                <td>{{ $petani->nama }}</td>
                                <td>{{ $petani->email }}</td>
                                <td>{{ $petani->alamat }}</td>
                                <td>{{ $petani->kontak }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" type="button" data-toggle="collapse"
                                        data-target="#detailPetani{{ $petani->id }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse" id="detailPetani{{ $petani->id }}">
                                <td colspan="5">
                                    <strong>Lahan:</strong>
                                    @if ($petani->lahans->isEmpty())
                                        <p class="text-muted">Belum memiliki lahan.</p>
                                    @else
                                        <ul class="mb-0">
                                            @foreach ($petani->lahans as $lahan)
                                                <li>
                                                    <strong>{{ $lahan->nama }}</strong> –
                                                    Lokasi: {{ $lahan->lokasi }},
                                                    Luas: {{ $lahan->luas }} m²
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection