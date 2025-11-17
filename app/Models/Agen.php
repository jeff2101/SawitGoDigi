<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agen extends Authenticatable
{
    use Notifiable;

    protected $table = 'sw_agens';
    public $timestamps = true;

    protected $rememberTokenName = null;

    protected $fillable = [
        'user_id',      // ⬅️ penting
        'id_usaha',
        'nama',
        'email',
        'alamat',
        'kontak',
        'password',
        'foto',
    ];

    protected $hidden = ['password'];

    public function usaha()
    {
        return $this->belongsTo(Usaha::class, 'id_usaha');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'agen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supirs()
    {
        return $this->hasMany(Supir::class, 'agen_id'); // FK di sw_supirs: agen_id
    }

}
