<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AnyAuth
{
    /**
     * Izinkan akses jika login sebagai admin, agen, petani, atau supir.
     * Jika belum login tapi sedang proses OTP, tetap izinkan.
     */
    public function handle($request, Closure $next)
    {
        // Jika sudah login di salah satu guard, lanjut
        foreach (['admin', 'agen', 'supir', 'petani'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // Jika sedang proses OTP (session masih ada), izinkan lanjut
        if (Session::has('otp_user_id') && Session::has('otp_user_type')) {
            return $next($request);
        }

        // Kalau tidak ada sesi sama sekali, arahkan ke login
        return redirect()->route('login')->withErrors(['error' => 'Sesi login tidak ditemukan.']);
    }
}
