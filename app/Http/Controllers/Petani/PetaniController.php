<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petani;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PetaniController extends Controller
{
    public function dashboard()
    {
        $petani = Auth::guard('petani')->user();

        $keuntunganHariIni = Transaksi::where('petani_id', $petani->id)
            ->whereDate('tanggal', Carbon::today())
            ->sum('total_bersih');

        $keuntunganBulanIni = Transaksi::where('petani_id', $petani->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('total_bersih');

        $keuntunganTahunIni = Transaksi::where('petani_id', $petani->id)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('total_bersih');

        return view('pages.petani.dashboard', compact(
            'petani',
            'keuntunganHariIni',
            'keuntunganBulanIni',
            'keuntunganTahunIni'
        ));
    }

    public function profile()
    {
        $petani = Auth::guard('petani')->user();
        return view('pages.petani.profile', compact('petani'));
    }

    public function updateProfile(Request $request)
    {
        $petani = Auth::guard('petani')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $petani->nama = $request->nama;
        $petani->alamat = $request->alamat;
        $petani->kontak = $request->kontak;

        if ($request->hasFile('foto')) {
            if ($petani->foto && file_exists(public_path('img/' . $petani->foto))) {
                unlink(public_path('img/' . $petani->foto));
            }

            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('img'), $imageName);
            $petani->foto = $imageName;
        }

        $petani->save();

        return redirect()->route('petani.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $petani = Auth::guard('petani')->user();
        $petani->password = Hash::make($request->password);
        $petani->save();

        return redirect()->route('petani.profile')->with('success', 'Password berhasil diperbarui.');
    }

    public function showPasswordForm()
    {
        return view('pages.petani.password');
    }
}
