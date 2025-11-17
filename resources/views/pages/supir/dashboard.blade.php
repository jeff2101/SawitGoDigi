@extends('layouts.supir.app')

@section('title', 'Dashboard Supir')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard Supir</h1>

    {{-- KARTU STATISTIK --}}
    <div class="row">
        @php
            $stats = [
                [
                    'label' => 'Penjemputan Hari Ini',
                    'count' => $penjemputanHariIni,
                    'color' => 'success',
                    'icon' => 'calendar-day',
                    'target' => '#modalHariIni',
                    'btn' => 'success'
                ],
                [
                    'label' => 'Penjemputan Bulan Ini',
                    'count' => $penjemputanBulanIni,
                    'color' => 'info',
                    'icon' => 'calendar-alt',
                    'target' => '#modalBulanIni',
                    'btn' => 'info'
                ],
                [
                    'label' => 'Penjemputan Tahun Ini',
                    'count' => $penjemputanTahunIni,
                    'color' => 'primary',
                    'icon' => 'calendar',
                    'target' => '#modalTahunIni',
                    'btn' => 'primary'
                ],
                [
                    'label' => 'Tugas Aktif',
                    'count' => $prosesAktif,
                    'color' => 'warning',
                    'icon' => 'truck',
                    'target' => '#modalAktif',
                    'btn' => 'warning'
                ]
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $stat['count'] }} {{ $stat['label'] == 'Tugas Aktif' ? 'Belum Selesai' : 'Penjemputan' }}
                                </div>
                                <button class="btn btn-sm btn-{{ $stat['btn'] }} mt-2" data-bs-toggle="modal"
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
    </div>

    {{-- CHART --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Penjemputan</h6>
            <form method="GET" action="{{ route('supir.dashboard') }}">
                <select name="range" onchange="this.form.submit()" class="form-select w-auto">
                    <option value="7hari" {{ $range == '7hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="bulanan" {{ $range == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="tahunan" {{ $range == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </form>
        </div>
        <div class="card-body">
            <canvas id="supirAreaChart"></canvas>
        </div>
    </div>

    {{-- MODAL REUSABLE --}}
    @php
        function renderPenjemputanTable($data)
        {
            if ($data->isEmpty()) {
                return '<p class="text-muted">Tidak ada data.</p>';
            }

            $html = '<div class="table-responsive"><table class="table table-bordered table-striped">';
            $html .= '<thead><tr>
                                        <th>No</th>
                                        <th>Petani</th>
                                        <th>Lokasi Jemput</th>
                                        <th>Tanggal</th>
                                        <th>Estimasi (kg)</th>
                                        <th>Status</th>
                                        <th>Maps</th>
                                      </tr></thead><tbody>';

            foreach ($data as $i => $row) {
                $html .= '<tr>';
                $html .= '<td>' . ($i + 1) . '</td>';
                $html .= '<td>' . ($row->petani->nama ?? '-') . '</td>';
                $html .= '<td>' . $row->lokasi_jemput . '</td>';
                $html .= '<td>' . \Carbon\Carbon::parse($row->tanggal_pemesanan)->format('d-m-Y') . '</td>';
                $html .= '<td>' . number_format($row->bobot_estimasi, 0, ',', '.') . '</td>';
                $html .= '<td><span class="badge bg-' . ($row->status_pemesanan === "selesai" ? "success" : "warning") . '">' . ucfirst($row->status_pemesanan) . '</span></td>';
                $html .= '<td>';
                $html .= $row->google_maps_url
                    ? '<a href="' . $row->google_maps_url . '" target="_blank" class="btn btn-sm btn-outline-info">Lihat</a>'
                    : '<span class="text-muted">-</span>';
                $html .= '</td></tr>';
            }

            $html .= '</tbody></table></div>';
            return $html;
        }
    @endphp

    {{-- MODALS --}}
    <div class="modal fade" id="modalHariIni" tabindex="-1" aria-labelledby="modalHariIniLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHariIniLabel">Detail Penjemputan Hari Ini</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderPenjemputanTable($dataHariIni) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBulanIni" tabindex="-1" aria-labelledby="modalBulanIniLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBulanIniLabel">Detail Penjemputan Bulan Ini</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderPenjemputanTable($dataBulanIni) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTahunIni" tabindex="-1" aria-labelledby="modalTahunIniLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTahunIniLabel">Detail Penjemputan Tahun Ini</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderPenjemputanTable($dataTahunIni) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAktif" tabindex="-1" aria-labelledby="modalAktifLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAktifLabel">Detail Tugas Penjemputan Aktif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {!! renderPenjemputanTable($dataTugasAktif) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('supirAreaChart').getContext('2d');

            // Set tinggi maksimum via JS (jika belum diberi style)
            document.getElementById('supirAreaChart').style.maxHeight = '300px';

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Penjemputan',
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
                    maintainAspectRatio: false, // penting agar ikut container
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => 'Jumlah: ' + ctx.parsed.y
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush