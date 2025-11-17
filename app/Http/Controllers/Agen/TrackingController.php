<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supir;

class TrackingController extends Controller
{
    /**
     * Menampilkan posisi semua supir yang sedang aktif dan punya lokasi.
     */
    public function index()
    {
        $supirs = Supir::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereHas('pemesanansAktif') // relasi dari model Supir
            ->get();

        return view('pages.agen.tracking.index', compact('supirs'));
    }
}
