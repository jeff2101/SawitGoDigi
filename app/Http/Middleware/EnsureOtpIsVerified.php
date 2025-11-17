<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnsureOtpIsVerified
{
    public function handle(Request $request, Closure $next): mixed
    {
        $exceptRoutes = [
            'otp.choose',
            'otp.send',
            'otp.verify.form',
            'otp.verify',
        ];

        if ($request->routeIs($exceptRoutes)) {
            return $next($request);
        }

        if (!Session::get('otp_verified')) {
            if (!Session::has('intended_after_otp')) {
                Session::put('intended_after_otp', $request->fullUrl());
            }
            return redirect()->route('otp.choose')->with('message', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        return $next($request);
    }



}
