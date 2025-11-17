<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Admin;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('user.login'); // form login tunggal untuk petani, agen, supir
    }

    public function login(Request $request)
    {
        if (Admin::where('email', $request->email)->exists()) {
            Alert::error('Login Gagal!', 'Silakan login melalui halaman admin.');
            return redirect()->route('admin.login');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|max:15',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Pastikan semua input valid.');
            return redirect()->back()->withInput();
        }

        $guards = ['agen', 'petani', 'supir'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt(['email' => $request->email, 'password' => $request->password])) {

                // ✅ Jika device tepercaya (middleware sudah set flag), LANGSUNG MASUK — SKIP OTP
                if (session('otp_verified') === true || $request->attributes->get('trusted_device_skip_otp') === true) {
                    toast("Login berhasil sebagai " . ucfirst($guard) . " (trusted device)", 'success');

                    // redirect per-guard
                    return match ($guard) {
                        'agen' => redirect()->route('agen.dashboard'),
                        'petani' => redirect()->route('petani.dashboard'),
                        'supir' => redirect()->route('supir.dashboard'),
                        default => redirect()->route('login'),
                    };
                }

                // 🔁 Kalau BUKAN trusted device → lanjut ke OTP (simpan sesi OTP)
                $this->storeOtpSession($guard);
                toast("Login berhasil sebagai " . ucfirst($guard), 'success');
                return redirect()->route('otp.choose');
            }
        }

        Alert::error('Login Gagal!', 'Email atau password salah.');
        return redirect()->back()->withInput();
    }

    /**
     * Simpan data sesi untuk proses OTP.
     */
    protected function storeOtpSession(string $guard)
    {
        $user = Auth::guard($guard)->user();
        Session::put('otp_verified', false);
        Session::put('otp_user_type', $guard);
        Session::put('otp_user_id', $user->id);
    }

    public function logout(Request $request)
    {
        foreach (['agen', 'petani', 'supir'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        Session::forget(['otp_verified', 'otp_user_type', 'otp_user_id']);

        toast('Berhasil logout!', 'success');
        return redirect()->route('login');
    }
}
