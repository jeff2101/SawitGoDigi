<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\Supir;

class SupirPetaniController extends Controller
{
    public function index()
    {
        $petaniId = Auth::guard('petani')->id();

        // Ambil id supir yang pernah menangani petani ini
        $supirIds = Pemesanan::where('id_petani', $petaniId)
            ->whereNotNull('id_supir')
            ->pluck('id_supir')
            ->unique();

        // Ambil data supir berdasarkan ID
        $supirs = Supir::whereIn('id', $supirIds)->get();

        return view('pages.petani.supir.index', compact('supirs'));
    }
}
