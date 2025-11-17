<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'sw_admins'; // Menentukan nama tabel jika tidak sesuai dengan konvensi


    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'password',
        'hak_akses',
        'foto',
    ];

    protected $hidden = [
        'password', // Menyembunyikan password dari array
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Mutator untuk hashing password sebelum disimpan
    public function setPasswordAttribute($value)
    {
        if (\Illuminate\Support\Str::startsWith($value, '$2y$')) {
            $this->attributes['password'] = $value; // Sudah ter-hash
        } else {
            $this->attributes['password'] = bcrypt($value); // Belum di-hash
        }
    }
}
