<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Harga_Jual;

class HargaJualPetaniController extends Controller
{
    public function index()
    {
        $hargaJuals = Harga_Jual::with('agen')->latest()->paginate(10);

        return view('pages.petani.hargajual.index', compact('hargaJuals'));
    }
}
