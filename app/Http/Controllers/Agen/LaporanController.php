<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Waktu sekarang
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // Ringkasan Keuntungan
        $keuntunganHariIni = DB::table('transaksis')
            ->whereDate('tanggal', $hariIni)
            ->where('agen_id', $userId)
            ->sum('total_bersih');

        $keuntunganBulanIni = DB::table('transaksis')
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->where('agen_id', $userId)
            ->sum('total_bersih');

        $keuntunganTahunIni = DB::table('transaksis')
            ->whereYear('tanggal', $tahunIni)
            ->where('agen_id', $userId)
            ->sum('total_bersih');

        // Rentang waktu grafik
        $bulanLalu = Carbon::now()->subMonth()->toDateString();
        $tahunLalu = Carbon::now()->subYear()->toDateString();
        $tujuhHariLalu = Carbon::now()->subDays(6)->toDateString(); // Termasuk hari ini

        // Grafik Penjualan
        $keuntungan7Hari = DB::table('transaksis')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(total_bersih) as total_untung')
            ->where('agen_id', $userId)
            ->whereDate('tanggal', '>=', $tujuhHariLalu)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $keuntunganBulan = DB::table('transaksis')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(total_bersih) as total_untung')
            ->where('agen_id', $userId)
            ->whereDate('tanggal', '>=', $bulanLalu)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $keuntunganTahun = DB::table('transaksis')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(total_bersih) as total_untung')
            ->where('agen_id', $userId)
            ->whereDate('tanggal', '>=', $tahunLalu)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Grafik Berat
        $berat7Hari = DB::table('transaksis')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(berat_tbs) as total_tbs, SUM(berat_brondol) as total_brondol')
            ->where('agen_id', $userId)
            ->whereDate('tanggal', '>=', $tujuhHariLalu)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $beratBulan = DB::table('transaksis')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(berat_tbs) as total_tbs, SUM(berat_brondol) as total_brondol')
            ->where('agen_id', $userId)
            ->whereDate('tanggal', '>=', $bulanLalu)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $beratTahun = DB::table('transaksis')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(berat_tbs) as total_tbs, SUM(berat_brondol) as total_brondol')
            ->where('agen_id', $userId)
            ->whereDate('tanggal', '>=', $tahunLalu)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('pages.agen.laporan.index', compact(
            'keuntunganHariIni',
            'keuntunganBulanIni',
            'keuntunganTahunIni',
            'keuntungan7Hari',
            'keuntunganBulan',
            'keuntunganTahun',
            'berat7Hari',
            'beratBulan',
            'beratTahun'
        ));
    }
}
