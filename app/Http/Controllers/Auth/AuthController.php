<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class AuthController extends Controller
{
    // Tampilkan form login admin
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    // Proses login admin
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:15',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Pastikan email dan password terisi dengan benar!');
            return redirect()->back()->withInput();
        }

        if (
            Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            $admin = Auth::guard('admin')->user();

            // ✅ CEK TRUSTED DEVICE - SKIP OTP jika device terpercaya
            if (session('otp_verified') === true || $request->attributes->get('trusted_device_skip_otp') === true) {
                // Set session untuk akses dashboard
                Session::put('otp_verified', true);
                Session::put('otp_user_type', 'admin');
                Session::put('otp_user_id', $admin->id);

                toast('Login berhasil sebagai Admin (trusted device)', 'success');
                return redirect()->route('admin.dashboard');
            }

            // ❌ Jika BUKAN trusted device, lanjut ke OTP
            Session::put('otp_verified', false);
            Session::put('otp_user_type', 'admin');
            Session::put('otp_user_id', $admin->id);

            toast('Login berhasil sebagai Admin', 'success');
            return redirect()->route('otp.choose');
        }

        Alert::error('Login Gagal!', 'Email atau password salah!');
        return redirect()->back()->withInput();
    }

    // Logout admin
    public function logout()
    {
        Auth::guard('admin')->logout();

        Session::forget(['otp_verified', 'otp_user_type', 'otp_user_id']);

        toast('Berhasil logout!', 'success');
        return redirect()->route('admin.login');
    }

}