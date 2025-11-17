<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Harga_Jual extends Model
{
    protected $table = 'sw_harga_juals';

    protected $fillable = [
        'agen_id',
        'harga_tbs',
        'harga_brondol',
        'waktu_ditetapkan',
        'catatan',
    ];

    protected $casts = [
        'waktu_ditetapkan' => 'datetime',
    ];


    /**
     * Relasi ke model Agen
     */
    public function agen(): BelongsTo
    {
        return $this->belongsTo(Agen::class, 'agen_id');
    }
}
