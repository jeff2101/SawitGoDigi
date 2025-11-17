<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'sw_pemesanans';

    protected $fillable = [
        'id_lahan',
        'id_petani',
        'id_supir',
        'lokasi_jemput',
        'google_maps_url',
        'latitude',
        'longitude',
        'bobot_estimasi',
        'jenis_pemesanan',
        'tanggal_pemesanan',
        'status_pemesanan',
    ];

    // Relasi ke Petani
    public function petani()
    {
        return $this->belongsTo(Petani::class, 'id_petani');
    }

    // Relasi ke Lahan (boleh null)
    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'id_lahan');
    }
}
