<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    // Table: abouts (otomatis dari Laravel)
    protected $fillable = [
        'judul',
        'deskripsi',
    ];
}
