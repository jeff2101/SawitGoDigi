<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TrustedDevice;

class CheckTrustedDevice
{
    public function handle(Request $request, Closure $next)
    {
        $cookie = $request->cookie('trusted_device');

        if ($cookie) {
            $data = json_decode($cookie, true);
            if (is_array($data) && isset($data['t'], $data['u'], $data['type'])) {
                $raw = $data['t'];
                $hash = hash('sha256', $raw);

                $device = TrustedDevice::where('user_type', $data['type'])
                    ->where('user_id', $data['u'])
                    ->where('token_hash', $hash)
                    ->whereNull('revoked_at')
                    ->first();

                if ($device && $device->isValid()) {
                    // tandai agar login melewati OTP
                    $request->attributes->set('trusted_device_skip_otp', true);
                    $request->attributes->set('trusted_device_user', [
                        'id' => $data['u'],
                        'type' => $data['type'],
                    ]);

                    // ⬇️ Tambahkan ini agar grup route yang pakai 'otp.verified' langsung lolos
                    session(['otp_verified' => true]);
                }
            }
        }

        return $next($request);
    }
}
