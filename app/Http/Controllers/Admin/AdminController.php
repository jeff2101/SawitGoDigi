<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

// Models
use App\Models\Admin;
use App\Models\Agen;
use App\Models\Petani;
use App\Models\Supir;
use App\Models\Transaksi;
use App\Models\Usaha;

class AdminController extends Controller
{
    // 📊 Dashboard utama
    public function dashboard(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        // Statistik umum
        $agenCount = Agen::count();
        $petaniCount = Petani::count();
        $transaksiCount = Transaksi::count();
        $totalKeuntungan = Transaksi::sum('total_bersih');

        // Ambil semua petani & agen untuk modal
        $petanis = Petani::all();
        $agens = Agen::all();

        // Ambil usaha dan agens (tanpa eager loading supir.transaksis)
        $usahas = Usaha::with(['agens.supirs'])->get();

        // Hitung total keuntungan dan transaksi terbaru per usaha
        foreach ($usahas as $usaha) {
            $agenIds = $usaha->agens->pluck('id');

            $usaha->keuntungan = Transaksi::whereIn('agen_id', $agenIds)->sum('total_bersih');

            $usaha->latestTransaksis = Transaksi::with('agen')
                ->whereIn('agen_id', $agenIds)
                ->latest()
                ->take(5)
                ->get();
        }

        // === Chart Total Keuntungan ===
        $range = $request->input('range', '7hari');
        $chartLabels = [];
        $chartData = [];

        if ($range === '7hari') {
            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::now()->subDays($i)->toDateString();
                $label = Carbon::parse($tanggal)->format('d M');
                $total = Transaksi::whereDate('created_at', $tanggal)->sum('total_bersih');
                $chartLabels[] = $label;
                $chartData[] = $total;
            }
        } elseif ($range === 'bulanan') {
            for ($i = 1; $i <= 12; $i++) {
                $label = Carbon::create()->month($i)->format('M');
                $total = Transaksi::whereMonth('created_at', $i)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_bersih');
                $chartLabels[] = $label;
                $chartData[] = $total;
            }
        } elseif ($range === 'tahunan') {
            $currentYear = Carbon::now()->year;
            for ($i = $currentYear - 4; $i <= $currentYear; $i++) {
                $label = (string) $i;
                $total = Transaksi::whereYear('created_at', $i)->sum('total_bersih');
                $chartLabels[] = $label;
                $chartData[] = $total;
            }
        }

        return view('pages.admin.dashboard', compact(
            'admin',
            'agenCount',
            'petaniCount',
            'transaksiCount',
            'totalKeuntungan',
            'usahas',
            'petanis',
            'agens',
            'range',
            'chartLabels',
            'chartData'
        ));
    }

    // 👩‍🌾 Daftar petani
    public function petanis()
    {
        $petanis = Petani::all();
        return view('pages.admin.petanis', compact('petanis'));
    }

    // 👤 Halaman profil admin
    public function profile()
    {
        $admin = auth()->guard('admin')->user();
        return view('pages.admin.profile', compact('admin'));
    }

    // ✏️ Update profil admin
    public function updateProfile(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:sw_admins,email,' . $admin->id,
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $admin->nama = $request->nama;
        $admin->email = $request->email;
        $admin->alamat = $request->alamat;
        $admin->no_hp = $request->no_hp;

        if ($request->hasFile('foto')) {
            if ($admin->foto && file_exists(public_path('img/' . $admin->foto))) {
                unlink(public_path('img/' . $admin->foto));
            }

            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img'), $imageName);
            $admin->foto = $imageName;
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // ❌ Hapus akun admin
    public function destroy()
    {
        $admin = auth()->guard('admin')->user();
        $admin->delete();

        Auth::guard('admin')->logout();

        return redirect()->route('login')->with('success', 'Akun berhasil dihapus.');
    }
}
