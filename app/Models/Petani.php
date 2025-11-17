<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petani extends Authenticatable
{
    use Notifiable;

    protected $table = 'sw_petanis';
    public $timestamps = true;

    protected $rememberTokenName = null;

    protected $fillable = [
        'user_id',      // ⬅️ penting
        'nama',
        'email',
        'alamat',
        'kontak',
        'password',
        'id_lahan',
        'foto',
    ];

    protected $hidden = ['password'];

    /**
     * Relasi ke banyak lahan (milik petani)
     */
    public function lahans(): HasMany
    {
        return $this->hasMany(Lahan::class, 'id_petani');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
