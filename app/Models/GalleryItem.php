<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    // Table: gallery_items
    protected $fillable = [
        'judul',
        'image_path',
    ];
}
