<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;

class TrackRecordController extends Controller
{
    public function index()
    {
        $supirId = Auth::guard('supir')->id(); // Ambil ID supir yang login

        $trackRecords = Pemesanan::with('petani')
            ->where('id_supir', $supirId)
            ->orderByDesc('tanggal_pemesanan')
            ->get();

        return view('pages.supir.trackrecord.index', compact('trackRecords'));
    }
}
