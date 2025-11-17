@extends('layouts.admin.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard Owner</h1>
    <div class="container-fluid">

        {{-- KARTU STATISTIK --}}
        @php
            $stats = [
                ['label' => 'Total Agen', 'count' => $agenCount, 'color' => 'primary', 'icon' => 'users', 'target' => '#modalAgen'],
                ['label' => 'Total Petani', 'count' => $petaniCount, 'color' => 'success', 'icon' => 'seedling', 'target' => '#modalPetani'],
                ['label' => 'Total Transaksi', 'count' => $transaksiCount, 'color' => 'info', 'icon' => 'exchange-alt', 'target' => '#modalTransaksi'],
                ['label' => 'Total Keuntungan', 'count' => 'Rp ' . number_format($totalKeuntungan, 0, ',', '.'), 'color' => 'warning', 'icon' => 'money-bill-wave', 'target' => '#']
            ];
        @endphp

        <div class="row">
            @foreach ($stats as $stat)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-{{ $stat['color'] }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                        {{ $stat['label'] }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $stat['count'] }}
                                    </div>
                                    @if ($stat['target'] !== '#')
                                        <button class="btn btn-sm btn-{{ $stat['color'] }} mt-2" data-bs-toggle="modal"
                                            data-bs-target="{{ $stat['target'] }}">
                                            View Details
                                        </button>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-{{ $stat['icon'] }} fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- MODAL AGEN --}}
        <div class="modal fade" id="modalAgen" tabindex="-1" aria-labelledby="modalAgenLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Daftar Agen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($agens->isEmpty())
                            <p class="text-muted">Tidak ada data agen.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Agen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agens as $i => $agen)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $agen->nama }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL PETANI --}}
        <div class="modal fade" id="modalPetani" tabindex="-1" aria-labelledby="modalPetaniLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Daftar Petani</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($petanis->isEmpty())
                            <p class="text-muted">Tidak ada data petani.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Petani</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($petanis as $i => $petani)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $petani->nama }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL TRANSAKSI --}}
        <div class="modal fade" id="modalTransaksi" tabindex="-1" aria-labelledby="modalTransaksiLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Daftar Transaksi Terbaru per Usaha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        @foreach ($usahas as $usaha)
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary">{{ $usaha->nama_usaha }}</h6>

                                @php
                                    $agenIds = $usaha->agens->pluck('id');
                                    $latestTransaksi = \App\Models\Transaksi::with('agen')
                                        ->whereIn('agen_id', $agenIds)
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp

                                @if ($latestTransaksi->isEmpty())
                                    <p class="text-muted">Tidak ada transaksi untuk usaha ini.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Agen</th>
                                                    <th>Total Bersih</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestTransaksi as $i => $trx)
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $trx->agen->nama ?? '-' }}</td>
                                                        <td>Rp {{ number_format($trx->total_bersih, 0, ',', '.') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK TOTAL KEUNTUNGAN --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Total Keuntungan</h6>
                <form method="GET" action="{{ route('admin.dashboard') }}">
                    <select name="range" onchange="this.form.submit()" class="form-select w-auto">
                        <option value="7hari" {{ $range == '7hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="bulanan" {{ $range == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="tahunan" {{ $range == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </form>
            </div>
            <div class="card-body">
                <canvas id="adminChart" style="max-height: 300px;"></canvas>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('adminChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Total Keuntungan (Rp)',
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