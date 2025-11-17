<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\OtpCode;
use App\Models\TrustedDevice;

class OtpController extends Controller
{
    /**
     * Nama route dashboard berdasarkan role.
     */
    private function dashboardRouteByRole(string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'agen' => 'agen.dashboard',
            'supir' => 'supir.dashboard',
            'petani' => 'petani.dashboard',
            default => 'login',
        };
    }

    /**
     * Tampilkan form pemilihan metode pengiriman OTP.
     */
    public function showMethodForm()
    {
        return view('auth.otp.choose-method');
    }

    /**
     * Kirim kode OTP ke media yang dipilih pengguna.
     * - Menentukan user & role aktif dari guard.
     * - Menghapus OTP lama yang belum tervalidasi.
     * - Mengirim OTP (email).
     * - Men-set sesi OTP.
     */
    public function send(Request $request)
    {
        $request->validate([
            'via' => 'required|in:email,sms',
        ]);

        // Temukan user dari guard yang saat ini aktif
        $guards = ['admin', 'agen', 'supir', 'petani'];
        $user = null;
        $userType = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $userType = $guard;
                break;
            }
        }

        if (!$user || !$userType) {
            return redirect()->route('login')->withErrors(['error' => 'Sesi pengguna tidak ditemukan. Silakan login kembali.']);
        }

        // (Opsional) Pastikan hanya satu guard aktif
        foreach ($guards as $g) {
            if ($g !== $userType && Auth::guard($g)->check()) {
                Auth::guard($g)->logout();
            }
        }

        // Hapus OTP yang belum diverifikasi sebelumnya
        OtpCode::where('user_type', $userType)
            ->where('user_id', $user->id)
            ->whereNull('verified_at')
            ->delete();

        // Generate OTP
        $kode = random_int(100000, 999999);
        $expired = Carbon::now()->addMinutes(1); // tetap 1 menit sesuai kode kamu

        OtpCode::create([
            'user_type' => $userType,
            'user_id' => $user->id,
            'kode_otp' => $kode,
            'via' => $request->via,
            'expired_at' => $expired,
        ]);

        // Kirim OTP (email). Untuk SMS: integrasikan gateway di sini.
        if ($request->via === 'email' && !empty($user->email)) {
            Mail::raw("Kode OTP Anda adalah: {$kode}", function ($message) use ($user) {
                $message->to($user->email)->subject('Kode OTP Anda');
            });
        }

        // Simpan info user ke session
        Session::put('otp_user_id', $user->id);
        Session::put('otp_user_type', $userType);
        Session::put('otp_verified', false);

        return redirect()->route('otp.verify.form')->with('success', 'Kode OTP telah dikirim!');
    }

    /**
     * Tampilkan form verifikasi OTP.
     */
    public function showVerifyForm()
    {
        $userId = Session::get('otp_user_id');
        $userType = Session::get('otp_user_type');

        if (!$userId || !$userType) {
            return redirect()->route('login')->withErrors(['error' => 'Session OTP tidak ditemukan.']);
        }

        // Ambil user berdasarkan tipe
        $user = match ($userType) {
            'admin' => \App\Models\Admin::find($userId),
            'agen' => \App\Models\Agen::find($userId),
            'supir' => \App\Models\Supir::find($userId),
            'petani' => \App\Models\Petani::find($userId),
            default => null,
        };

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User tidak ditemukan.']);
        }

        // Ambil OTP terakhir
        $lastOtp = OtpCode::where('user_type', $userType)
            ->where('user_id', $userId)
            ->latest()
            ->first();

        // Tentukan media terakhir (fallback: email bila tersedia)
        $via = $lastOtp?->via ?? (!empty($user->email) ? 'email' : 'sms');

        // Ambil nomor HP dari no_hp atau kontak (kalau tersedia)
        $rawPhone = $user->no_hp ?? $user->kontak ?? null;

        // Format tujuan pengiriman OTP untuk ditampilkan
        $tujuan = match ($via) {
            'email' => !empty($user->email)
            ? (substr($user->email, 0, 3) . '****' . strstr($user->email, '@'))
            : 'email Anda',
            'sms' => !empty($rawPhone)
            ? (substr($rawPhone, 0, 4) . '****' . substr($rawPhone, -2))
            : 'nomor HP Anda',
            default => 'akun Anda',
        };

        return view('auth.otp.verify', compact('tujuan'));
    }

    /**
     * Verifikasi kode OTP.
     * Mendukung "ingat perangkat 90 hari" via remember_device.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'kode_otp' => 'required|digits:6',
            'remember_device' => 'nullable|boolean',
        ]);

        $userId = Session::get('otp_user_id');
        $userType = Session::get('otp_user_type');

        if (!$userId || !$userType) {
            return redirect()->route('login')->withErrors(['error' => 'Session OTP tidak valid.']);
        }

        $otp = OtpCode::where([
            'user_id' => $userId,
            'user_type' => $userType,
            'kode_otp' => $request->kode_otp,
        ])->latest()->first();

        if (!$otp || !method_exists($otp, 'isValid') || !$otp->isValid()) {
            return back()->withErrors(['kode_otp' => 'Kode OTP salah atau sudah kedaluwarsa.']);
        }

        // Tandai OTP sebagai telah diverifikasi
        if (method_exists($otp, 'markAsVerified')) {
            $otp->markAsVerified();
        } else {
            $otp->verified_at = Carbon::now();
            $otp->save();
        }

        // Set dan simpan session OTP
        Session::put('otp_verified', true);
        Session::save();

        // Jika user centang "ingat perangkat 90 hari", set cookie trusted_device
        $cookie = null;
        if ($request->boolean('remember_device')) {
            $cookie = $this->createTrustedDeviceCookie($userId, $userType, $request);
        }

        // PRIORITAS 1: kembali ke intended jika ada
        if ($url = Session::pull('intended_after_otp')) {
            return $cookie
                ? redirect()->to($url)->with('success', 'Login berhasil!')->cookie($cookie)
                : redirect()->to($url)->with('success', 'Login berhasil!');
        }

        // PRIORITAS 2: dashboard sesuai role
        $routeName = $this->dashboardRouteByRole($userType);

        return $cookie
            ? redirect()->route($routeName)->with('success', 'Login berhasil!')->cookie($cookie)
            : redirect()->route($routeName)->with('success', 'Login berhasil!');
    }

    /**
     * Buat cookie trusted_device 90 hari dan simpan hash ke DB.
     */
    protected function createTrustedDeviceCookie(int $userId, string $userType, Request $request)
    {
        // Token untuk client (raw) dan hash untuk server (DB)
        $rawToken = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $rawToken);
        $expires = Carbon::now()->addDays(90);

        TrustedDevice::create([
            'user_type' => $userType,
            'user_id' => $userId,
            'device_name' => $request->header('X-Device-Name') ?: 'Unknown',
            'token_hash' => $tokenHash,
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'ip_address' => $request->ip(),
            'expires_at' => $expires,
        ]);

        $payload = json_encode([
            't' => $rawToken,
            'u' => $userId,
            'type' => $userType,
        ]);

        $minutes = 60 * 24 * 90; // 90 hari
        $domain = config('session.domain') ?: null;
        $secure = config('app.env') !== 'local'; // secure di semua env kecuali local

        // Cookie aman: Secure (kecuali local), HttpOnly, SameSite=Lax
        return Cookie::make(
            'trusted_device',
            $payload,
            $minutes,
            '/',
            $domain,
            $secure,
            true,   // HttpOnly
            false,  // raw
            'Lax'
        );
    }
}
