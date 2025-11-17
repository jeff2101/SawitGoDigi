<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Petani;

class DataPetaniController extends Controller
{
    public function index()
    {
        // Ambil semua petani beserta lahannya
        $petanis = Petani::with('lahans')->get();

        return view('pages.agen.data-petani.index', compact('petanis'));
    }
}
