<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Petani;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:sw_petanis,email',
            'kontak' => 'required|string|max:12|unique:sw_petanis,kontak',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal Daftar', 'Periksa kembali input Anda.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Petani::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'kontak' => $request->kontak,
            'password' => Hash::make($request->password),
        ]);

        toast('Registrasi berhasil, silakan login!', 'success');
        return redirect()->route('login');
    }
}
