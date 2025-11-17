<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class TransaksiPetaniController extends Controller
{
    public function index()
    {
        $petaniId = Auth::guard('petani')->id();
        $transaksis = Transaksi::where('petani_id', $petaniId)
            ->latest()
            ->get();
        $totalBersih = $transaksis->sum('total_bersih');

        return view('pages.petani.transaksi.index', compact('transaksis', 'totalBersih'));
    }

    public function show($id)
    {
        $petaniId = Auth::guard('petani')->id();
        $transaksi = Transaksi::where('petani_id', $petaniId)
            ->findOrFail($id);

        return view('pages.petani.transaksi.show', compact('transaksi'));
    }
}
