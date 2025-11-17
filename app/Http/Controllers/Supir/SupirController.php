<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supir;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SupirController extends Controller
{
    public function dashboard(Request $request)
    {
        $supir = Auth::guard('supir')->user();

        $pemesananIds = Pemesanan::where('id_supir', $supir->id)->pluck('id');

        $penjemputanHariIni = Pemesanan::whereIn('id', $pemesananIds)
            ->whereDate('tanggal_pemesanan', Carbon::today())
            ->count();

        $penjemputanBulanIni = Pemesanan::whereIn('id', $pemesananIds)
            ->whereMonth('tanggal_pemesanan', Carbon::now()->month)
            ->whereYear('tanggal_pemesanan', Carbon::now()->year)
            ->count();

        $penjemputanTahunIni = Pemesanan::whereIn('id', $pemesananIds)
            ->whereYear('tanggal_pemesanan', Carbon::now()->year)
            ->count();

        $prosesAktif = Pemesanan::whereIn('id', $pemesananIds)
            ->where('status_pemesanan', '!=', 'selesai')
            ->count();

        $dataHariIni = Pemesanan::with('petani')
            ->whereIn('id', $pemesananIds)
            ->whereDate('tanggal_pemesanan', Carbon::today())
            ->get();

        $dataBulanIni = Pemesanan::with('petani')
            ->whereIn('id', $pemesananIds)
            ->whereMonth('tanggal_pemesanan', Carbon::now()->month)
            ->whereYear('tanggal_pemesanan', Carbon::now()->year)
            ->get();

        $dataTahunIni = Pemesanan::with('petani')
            ->whereIn('id', $pemesananIds)
            ->whereYear('tanggal_pemesanan', Carbon::now()->year)
            ->get();

        $dataTugasAktif = Pemesanan::with('petani')
            ->whereIn('id', $pemesananIds)
            ->whereIn('status_pemesanan', ['proses', 'dijemput'])
            ->orderBy('tanggal_pemesanan', 'desc')
            ->get();

        // Chart Data Preparation
        $range = $request->input('range', '7hari');
        $chartLabels = [];
        $chartData = [];

        if ($range === '7hari') {
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::today()->subDays($i);
                $label = $tanggal->format('d M');
                $count = Pemesanan::whereIn('id', $pemesananIds)
                    ->whereDate('tanggal_pemesanan', $tanggal)
                    ->count();
                $chartLabels[] = $label;
                $chartData[] = $count;
            }
        } elseif ($range === 'bulanan') {
            for ($i = 1; $i <= 12; $i++) {
                $label = Carbon::create()->month($i)->format('M');
                $count = Pemesanan::whereIn('id', $pemesananIds)
                    ->whereMonth('tanggal_pemesanan', $i)
                    ->whereYear('tanggal_pemesanan', Carbon::now()->year)
                    ->count();
                $chartLabels[] = $label;
                $chartData[] = $count;
            }
        } elseif ($range === 'tahunan') {
            $currentYear = Carbon::now()->year;
            for ($i = $currentYear - 4; $i <= $currentYear; $i++) {
                $label = (string) $i;
                $count = Pemesanan::whereIn('id', $pemesananIds)
                    ->whereYear('tanggal_pemesanan', $i)
                    ->count();
                $chartLabels[] = $label;
                $chartData[] = $count;
            }
        }

        return view('pages.supir.dashboard', compact(
            'supir',
            'penjemputanHariIni',
            'penjemputanBulanIni',
            'penjemputanTahunIni',
            'prosesAktif',
            'dataHariIni',
            'dataBulanIni',
            'dataTahunIni',
            'dataTugasAktif',
            'chartLabels',
            'chartData',
            'range'
        ));
    }

    public function profile()
    {
        $supir = Auth::guard('supir')->user();
        return view('pages.supir.profile', compact('supir'));
    }

    public function updateProfile(Request $request)
    {
        $supir = Auth::guard('supir')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:20',
            'jenis_kendaraan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $supir->nama = $request->nama;
        $supir->kontak = $request->kontak;
        $supir->jenis_kendaraan = $request->jenis_kendaraan;

        if ($request->hasFile('foto')) {
            if ($supir->foto && file_exists(public_path('img/' . $supir->foto))) {
                unlink(public_path('img/' . $supir->foto));
            }

            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img'), $imageName);
            $supir->foto = $imageName;
        }

        $supir->save();

        return redirect()->route('supir.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
