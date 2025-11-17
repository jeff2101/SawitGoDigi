<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supir extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'sw_supirs';
    public $timestamps = true;

    // Nonaktifkan remember_token kalau kolomnya tidak ada di tabel
    protected $rememberTokenName = null;

    protected $fillable = [
        'user_id',          // ⬅️ penting agar terisi
        'agen_id',
        'nama',
        'kontak',
        'email',
        'jenis_kendaraan',
        'password',
        'foto',
        'latitude',
        'longitude',
        'last_updated_location',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi yang benar
    public function agen()
    {
        return $this->belongsTo(Agen::class, 'agen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hapus relasi lahans() karena itu milik Petani
}
