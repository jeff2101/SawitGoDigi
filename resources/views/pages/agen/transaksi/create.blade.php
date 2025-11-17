@extends('layouts.agen.app')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Tambah Transaksi</h4>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('agen.transaksi.store') }}">
                    @csrf

                    {{-- Informasi Umum --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Petani</label>
                            <select name="petani_id" id="petani_id" class="form-control">
                                <option value="">-- Pilih Petani --</option>
                                @foreach($petanis as $petani)
                                    <option value="{{ $petani->id }}">{{ $petani->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pemesanan</label>
                            <select name="pemesanan_id" id="pemesanan_id" class="form-control">
                                <option value="">-- Pilih Pemesanan --</option>
                                @foreach($pemesanans as $pemesanan)
                                    <option value="{{ $pemesanan->id }}">#{{ $pemesanan->id }} - {{ $pemesanan->lokasi_jemput }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Estimasi --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Nama Petani</label>
                            <input type="text" id="petani_nama_display" class="form-control" disabled>
                        </div>
                        <div class="col-md-4">
                            <label>Estimasi Berat Awal</label>
                            <input type="text" id="estimasi_berat_display" class="form-control" disabled>
                            <input type="hidden" id="estimasi_berat_hidden" name="estimasi_berat">
                        </div>
                    </div>

                    {{-- Detail Buah A & B & Brondol --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Berat Buah A (Kg)</label>
                            <input type="number" step="0.01" name="berat_tbs_a" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Harga Buah A (Rp/Kg)</label>
                            <input type="number" step="1" name="harga_tbs_a" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Mutu Buah A</label>
                            <select name="mutu_buah_a" class="form-control">
                                <option value="mentah">Mentah</option>
                                <option value="matang">Matang</option>
                                <option value="busuk">Busuk</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Berat Buah B (Kg)</label>
                            <input type="number" step="0.01" name="berat_tbs_b" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Harga Buah B (Rp/Kg)</label>
                            <input type="number" step="1" name="harga_tbs_b" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Mutu Buah B</label>
                            <select name="mutu_buah_b" class="form-control">
                                <option value="mentah">Mentah</option>
                                <option value="matang">Matang</option>
                                <option value="busuk">Busuk</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Berat Brondol (Kg)</label>
                            <input type="number" step="0.01" name="berat_brondol" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Harga Brondol (Rp/Kg)</label>
                            <input type="number" step="1" name="harga_brondol" class="form-control">
                        </div>
                    </div>

                    {{-- Potongan --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Potongan Berat (%)</label>
                            <input type="number" step="0.01" name="potongan_berat" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Potongan Alas Timbang (Kg)</label>
                            <input type="number" step="0.01" name="potongan_alas_timbang" class="form-control">
                        </div>
                    </div>

                    {{-- Lainnya --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Mutu Buah Utama (opsional)</label>
                            <select name="mutu_buah" class="form-control">
                                <option value="mentah">Mentah</option>
                                <option value="matang">Matang</option>
                                <option value="busuk">Busuk</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Jenis Transaksi</label>
                            <select name="jenis_transaksi" id="jenis_transaksi" class="form-control" required>
                                <option value="langsung">Langsung</option>
                                <option value="pesanan">Pesanan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-control" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <a href="{{ route('agen.transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pemesananSelect = document.getElementById('pemesanan_id');
            const petaniSelect = document.getElementById('petani_id');
            const petaniNamaDisplay = document.getElementById('petani_nama_display');
            const estimasiDisplay = document.getElementById('estimasi_berat_display');
            const estimasiHidden = document.getElementById('estimasi_berat_hidden');
            const jenisTransaksi = document.getElementById('jenis_transaksi');

            pemesananSelect.addEventListener('change', function () {
                const id = this.value;
                jenisTransaksi.value = id ? 'pesanan' : 'langsung';

                if (!id) {
                    petaniSelect.value = '';
                    petaniNamaDisplay.value = '';
                    estimasiDisplay.value = '';
                    estimasiHidden.value = '';
                    return;
                }

                fetch(`/agen/transaksi/get-pemesanan/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        petaniSelect.value = data.petani_id;
                        petaniNamaDisplay.value = data.petani_nama || '-';
                        estimasiDisplay.value = data.estimasi_berat + ' Kg';
                        estimasiHidden.value = data.estimasi_berat;
                    });
            });
        });
    </script>
@endpush