@extends('layouts.agen.app')

@section('title', 'Laporan')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Laporan Pencatatan</h1>

        <!-- Ringkasan Penjualan -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Penjualan Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($keuntunganHariIni, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Penjualan Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($keuntunganBulanIni, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penjualan Tahun Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($keuntunganTahunIni, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Waktu -->
        <div class="mb-3">
            <label for="rangeSelector">Rentang Waktu</label>
            <select id="rangeSelector" class="form-control w-auto d-inline-block">
                <option value="week">7 Hari Terakhir</option>
                <option value="month">1 Bulan Terakhir</option>
                <option value="year">1 Tahun Terakhir</option>
            </select>
        </div>

        <!-- Grafik -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header font-weight-bold text-primary">Grafik Penjualan</div>
                    <div class="card-body">
                        <canvas id="chartPenjualan"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header font-weight-bold text-success">Grafik Berat TBS & Brondol</div>
                    <div class="card-body">
                        <canvas id="chartBerat"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        const dataKeuntungan = {
            week: {
                labels: {!! json_encode($keuntungan7Hari->pluck('tanggal')) !!},
                data: {!! json_encode($keuntungan7Hari->pluck('total_untung')) !!}
            },
            month: {
                labels: {!! json_encode($keuntunganBulan->pluck('tanggal')) !!},
                data: {!! json_encode($keuntunganBulan->pluck('total_untung')) !!}
            },
            year: {
                labels: {!! json_encode($keuntunganTahun->pluck('tanggal')) !!},
                data: {!! json_encode($keuntunganTahun->pluck('total_untung')) !!}
            }
        };

        const dataBerat = {
            week: {
                labels: {!! json_encode($berat7Hari->pluck('tanggal')) !!},
                tbs: {!! json_encode($berat7Hari->pluck('total_tbs')) !!},
                brondol: {!! json_encode($berat7Hari->pluck('total_brondol')) !!}
            },
            month: {
                labels: {!! json_encode($beratBulan->pluck('tanggal')) !!},
                tbs: {!! json_encode($beratBulan->pluck('total_tbs')) !!},
                brondol: {!! json_encode($beratBulan->pluck('total_brondol')) !!}
            },
            year: {
                labels: {!! json_encode($beratTahun->pluck('tanggal')) !!},
                tbs: {!! json_encode($beratTahun->pluck('total_tbs')) !!},
                brondol: {!! json_encode($beratTahun->pluck('total_brondol')) !!}
            }
        };

        let chartPenjualan, chartBerat;

        function renderCharts(range) {
            const ctx1 = document.getElementById('chartPenjualan').getContext('2d');
            const ctx2 = document.getElementById('chartBerat').getContext('2d');

            if (chartPenjualan) chartPenjualan.destroy();
            if (chartBerat) chartBerat.destroy();

            chartPenjualan = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: dataKeuntungan[range].labels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: dataKeuntungan[range].data,
                        backgroundColor: 'rgba(78, 115, 223, 0.7)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
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
                                callback: value => 'Rp ' + value.toLocaleString('id-ID')
                            }
                        }
                    }
                }
            });

            chartBerat = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: dataBerat[range].labels,
                    datasets: [
                        {
                            label: 'TBS (Kg)',
                            data: dataBerat[range].tbs,
                            backgroundColor: 'rgba(28, 200, 138, 0.8)'
                        },
                        {
                            label: 'Brondol (Kg)',
                            data: dataBerat[range].brondol,
                            backgroundColor: 'rgba(255, 193, 7, 0.8)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.dataset.label + ': ' + ctx.parsed.y.toLocaleString('id-ID') + ' Kg'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => value.toLocaleString('id-ID') + ' Kg'
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const rangeSelector = document.getElementById('rangeSelector');
            renderCharts('week'); // Default ke 7 hari terakhir

            rangeSelector.addEventListener('change', () => {
                renderCharts(rangeSelector.value);
            });
        });
    </script>
@endpush