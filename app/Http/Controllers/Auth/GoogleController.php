<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\OtpCode;
use App\Models\Admin;
use App\Models\Agen;
use App\Models\Supir;
use App\Models\Petani;

class GoogleController extends Controller
{
    /**
     * =============================
     * 👤 LOGIN GOOGLE USER UMUM
     * =============================
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Gagal login lewat Google.']);
        }

        // cari user di tabel users
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Akun Google tidak terdaftar di sistem.']);
        }

        $role = $user->role;

        $modelMap = [
            'admin' => Admin::class,
            'agen' => Agen::class,
            'supir' => Supir::class,
            'petani' => Petani::class,
        ];

        if (!isset($modelMap[$role])) {
            return redirect()->route('login')->withErrors(['error' => 'Role tidak dikenali.']);
        }

        $swModel = $modelMap[$role];
        $swUser = $swModel::where('email', $user->email)->first();

        if (!$swUser) {
            return redirect()->route('login')->withErrors([
                'error' => "Data pengguna belum ada di tabel {$swModel}. Pastikan email sama dengan di tabel users."
            ]);
        }

        // logout guard lain KECUALI role sekarang
        foreach (['admin', 'agen', 'supir', 'petani'] as $g) {
            if ($g !== $role && Auth::guard($g)->check()) {
                Auth::guard($g)->logout();
            }
        }

        Auth::guard($role)->login($swUser);
        Session::save();

        $cookie = request()->cookie('trusted_device');
        if ($cookie) {
            $data = json_decode($cookie, true);
            if (is_array($data) && isset($data['t'], $data['u'], $data['type'])) {
                if ($data['u'] == $swUser->id && $data['type'] == $role) {
                    $hash = hash('sha256', $data['t']);

                    $device = \App\Models\TrustedDevice::where('user_type', $role)
                        ->where('user_id', $swUser->id)
                        ->where('token_hash', $hash)
                        ->whereNull('revoked_at')
                        ->where('expires_at', '>', now())
                        ->first();

                    if ($device) {
                        Session::put('otp_verified', true);
                        Session::put('otp_user_id', $swUser->id);
                        Session::put('otp_user_type', $role);

                        $routeName = match ($role) {
                            'admin' => 'admin.dashboard',
                            'agen' => 'agen.dashboard',
                            'supir' => 'supir.dashboard',
                            'petani' => 'petani.dashboard',
                            default => 'login',
                        };

                        return redirect()->route($routeName)
                            ->with('success', 'Login Google berhasil (trusted device)!');
                    }
                }
            }
        }

        // buat OTP
        $kode = rand(100000, 999999);
        $expired = Carbon::now()->addMinutes(5);

        OtpCode::where('user_type', $role)
            ->where('user_id', $swUser->id)
            ->delete();

        OtpCode::create([
            'user_type' => $role,
            'user_id' => $swUser->id,
            'kode_otp' => $kode,
            'via' => 'email',
            'expired_at' => $expired,
        ]);

        Mail::raw("Kode OTP Anda: {$kode}", function ($msg) use ($swUser) {
            $msg->to($swUser->email)->subject('Kode OTP Login');
        });

        Session::put('otp_user_id', $swUser->id);
        Session::put('otp_user_type', $role);
        Session::put('otp_verified', false);
        Session::save();

        return redirect()->route('otp.verify.form')
            ->with('success', 'Login berhasil. Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * =============================
     * 🛡️ LOGIN GOOGLE KHUSUS ADMIN
     * =============================
     */
    public function redirectToGoogleAdmin()
    {
        return Socialite::buildProvider(GoogleProvider::class, config('services.google_admin'))
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallbackAdmin()
    {
        try {
            $googleUser = Socialite::buildProvider(GoogleProvider::class, config('services.google_admin'))->user();
        } catch (\Exception $e) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Gagal login lewat Google.']);
        }

        // cek user di tabel users
        $user = User::where('email', $googleUser->getEmail())->first();
        if (!$user || $user->role !== 'admin') {
            return redirect()->route('admin.login')->withErrors(['error' => 'Akun Google tidak terdaftar sebagai admin.']);
        }

        // cari di tabel admin
        $swAdmin = Admin::where('email', $user->email)->first();
        if (!$swAdmin) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Data admin belum ditemukan di sistem.']);
        }

        // logout guard lain
        foreach (['agen', 'supir', 'petani'] as $g) {
            if (Auth::guard($g)->check()) {
                Auth::guard($g)->logout();
            }
        }

        Auth::guard('admin')->login($swAdmin);
        Session::save();

        // ✅ CEK TRUSTED DEVICE - KHUSUS ADMIN
        $cookie = request()->cookie('trusted_device');
        if ($cookie) {
            $data = json_decode($cookie, true);
            if (is_array($data) && isset($data['t'], $data['u'], $data['type'])) {
                if ($data['u'] == $swAdmin->id && $data['type'] == 'admin') {
                    $hash = hash('sha256', $data['t']);

                    $device = \App\Models\TrustedDevice::where('user_type', 'admin')
                        ->where('user_id', $swAdmin->id)
                        ->where('token_hash', $hash)
                        ->whereNull('revoked_at')
                        ->where('expires_at', '>', now())
                        ->first();

                    if ($device) {
                        Session::put('otp_verified', true);
                        Session::put('otp_user_id', $swAdmin->id);
                        Session::put('otp_user_type', 'admin');

                        return redirect()->route('admin.dashboard')
                            ->with('success', 'Login Google Admin berhasil (trusted device)!');
                    }
                }
            }
        }

        // buat OTP
        $kode = rand(100000, 999999);
        $expired = now()->addMinutes(5);

        OtpCode::where('user_type', 'admin')
            ->where('user_id', $swAdmin->id)
            ->delete();

        OtpCode::create([
            'user_type' => 'admin',
            'user_id' => $swAdmin->id,
            'kode_otp' => $kode,
            'via' => 'email',
            'expired_at' => $expired,
        ]);

        Mail::raw("Kode OTP Anda: {$kode}", function ($msg) use ($swAdmin) {
            $msg->to($swAdmin->email)->subject('Kode OTP Login Admin');
        });

        Session::put('otp_user_id', $swAdmin->id);
        Session::put('otp_user_type', 'admin');
        Session::put('otp_verified', false);
        Session::save();

        return redirect()->route('otp.verify.form')
            ->with('success', 'Login berhasil. Kode OTP telah dikirim ke email Anda.');
    }
}
