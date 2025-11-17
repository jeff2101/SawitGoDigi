<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usaha extends Model
{
    protected $table = 'usahas';

    protected $fillable = [
        'nama_usaha',
        'alamat',
        'kontak',
    ];

    // 🔁 Relasi: Usaha punya banyak agen
    public function agens()
    {
        return $this->hasMany(Agen::class, 'id_usaha');
    }
}
