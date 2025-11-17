<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OtpCode extends Model
{
    protected $table = 'otp_codes';

    protected $fillable = [
        'user_type',
        'user_id',
        'kode_otp',
        'via',
        'expired_at',
        'verified_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Cek apakah OTP masih berlaku.
     */
    public function isValid(): bool
    {
        return $this->expired_at instanceof Carbon
            && is_null($this->verified_at)
            && $this->expired_at->isFuture();
    }

    /**
     * Tandai OTP sebagai terverifikasi.
     */
    public function markAsVerified(): void
    {
        $this->update(['verified_at' => now()]);
    }

    /**
     * Relasi polymorphic ke user (opsional).
     */
    public function user()
    {
        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }
}
