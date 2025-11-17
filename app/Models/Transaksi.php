<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'agen_id',
        'petani_id',
        'pemesanan_id',
        'jenis_transaksi',

        // Berat dan potongan
        'berat_tbs',
        'berat_brondol',
        'potongan_persen',
        'potongan_alas_timbang',

        // Berat dan mutu per jenis
        'berat_tbs_a',
        'berat_tbs_b',
        'mutu_buah_a',
        'mutu_buah_b',
        'mutu_buah',

        // Harga
        'harga_tbs_a',
        'harga_tbs_b',
        'harga_brondol',

        // Total
        'total_harga_awal',
        'total_bersih',

        // Lain-lain
        'metode_pembayaran',
        'tanggal',
        'bukti_transaksi',
    ];

    // Relasi
    public function agen()
    {
        return $this->belongsTo(Agen::class, 'agen_id');
    }

    public function petani()
    {
        return $this->belongsTo(Petani::class, 'petani_id');
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}
