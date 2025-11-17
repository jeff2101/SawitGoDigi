<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lahan extends Model
{
    protected $table = 'sw_lahans';

    protected $fillable = [
        'id_petani',
        'nama',
        'lokasi',
        'luas',
        'maps_url',
        'latitude',   // tambahkan ini
        'longitude',  // dan ini
    ];

    /**
     * Relasi ke model Petani
     */
    public function petani(): BelongsTo
    {
        return $this->belongsTo(Petani::class, 'id_petani');
    }
}
