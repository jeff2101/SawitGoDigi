@extends('layouts.agen.app')

@section('title', 'Dashboard Agen')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard Agen</h1>

    {{-- KARTU STATISTIK --}}
    <div class="row">
        @php
            $stats = [
                [
                    'label' => 'Penjualan Bulan Ini',
                    'value' => 'Rp ' . number_format($penjualanBulanan, 0, ',', '.'),
                    'color' => 'primary',
                    'icon' => 'money-bill-wave',
                    'target' => '#modalPenjualan'
                ],
                [
                    'label' => 'Jumlah Petani',
                    'value' => $jumlahPetani,
                    'color' => 'success',
                    'icon' => 'users',
                    'target' => '#modalPetani'
                ],
                [
                    'label' => 'Jumlah Supir',
                    'value' => $jumlahSupir,
                    'color' => 'warning',
                    'icon' => 'truck',
                    'target' => '#modalSupir'
                ],
                [
                    'label' => 'Jumlah Transaksi',
                    'value' => $jumlahTransaksi,
                    'color' => 'info',
                    'icon' => 'file-invoice-dollar',
                    'target' => '#modalTransaksi'
                ],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-{{ $stat['color'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                    {{ $stat['label'] }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['value'] }}</div>
                                <button class="btn btn-sm btn-{{ $stat['color'] }} mt-2" data-bs-toggle="modal"
                                    data-bs-target="{{ $stat['target'] }}">
                                    View Details
                                </button>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-{{ $stat['icon'] }} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Harga TBS & Brondol --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2 text-center">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Harga TBS Saat Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp {{ number_format($hargaTbs, 0, ',', '.') }} /kg
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2 text-center">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Harga Brondol Saat Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp {{ number_format($hargaBrondol, 0, ',', '.') }} /kg
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRAFIK PENJUALAN --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Total Penjualan</h6>
            <form method="GET" action="{{ route('agen.dashboard') }}">
                <select name="range" onchange="this.form.submit()" class="form-select w-auto">
                    <option value="7hari" {{ $range == '7hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="bulanan" {{ $range == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="tahunan" {{ $range == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </form>
        </div>
        <div class="card-body">
            <canvas id="agenChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    {{-- MODALS --}}
    @php
        function renderListTable($data, $headers = [], $rows = [])
        {
            if (empty($data) || count($data) === 0) {
                return '<p class="text-muted">Tidak ada data.</p>';
            }

            $html = '<div class="table-responsive"><table class="table table-bordered table-striped"><thead><tr>';
            foreach ($headers as $h)
                $html .= "<th>{$h}</th>";
            $html .= '</tr></thead><tbody>';

            foreach ($data as $index => $item) {
                $html .= '<tr>';
                foreach ($rows as $row) {
                    $html .= '<td>' . ($row($item, $index) ?? '-') . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</tbody></table></div>';
            return $html;
        }
    @endphp

    {{-- Modal Petani --}}
    <div class="modal fade" id="modalPetani" tabindex="-1" aria-labelledby="modalPetaniLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPetaniLabel">Detail Petani</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderListTable($petanis ?? [], ['No', 'Nama', 'Alamat'], [
        fn($p, $i) => $i + 1,
        fn($p) => $p->nama,
        fn($p) => $p->alamat,
    ]) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Supir --}}
    <div class="modal fade" id="modalSupir" tabindex="-1" aria-labelledby="modalSupirLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSupirLabel">Detail Supir</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderListTable($supirs ?? [], ['No', 'Nama', 'No HP'], [
        fn($s, $i) => $i + 1,
        fn($s) => $s->nama,
        fn($s) => $s->kontak,
    ]) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Transaksi --}}
    <div class="modal fade" id="modalTransaksi" tabindex="-1" aria-labelledby="modalTransaksiLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransaksiLabel">Detail Transaksi</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderListTable($transaksis ?? [], ['No', 'Tanggal', 'Total Bersih (Rp)'], [
        fn($t, $i) => $i + 1,
        fn($t) => \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y'),
        fn($t) => number_format($t->total_bersih, 0, ',', '.'),
    ]) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Penjualan --}}
    <div class="modal fade" id="modalPenjualan" tabindex="-1" aria-labelledby="modalPenjualanLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPenjualanLabel">Detail Penjualan Bulan Ini</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Total Penjualan Bulan Ini: <strong>Rp {{ number_format($penjualanBulanan, 0, ',', '.') }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('agenChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: {!! json_encode($chartData) !!},
                        fill: true,
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderColor: '#4e73df',
                        pointBackgroundColor: '#4e73df',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush