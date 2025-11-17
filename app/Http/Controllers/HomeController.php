<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\VisiMisi;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\Testimoni;
use App\Models\Faq;
use App\Models\ContactInfo;

class HomeController extends Controller
{
    public function index()
    {
        $about = About::first();
        $visiMisi = VisiMisi::first();
        $features = Feature::all();
        $galleries = GalleryItem::all();
        $testimonials = Testimoni::all();
        $faqs = Faq::all();
        $contactInfo = ContactInfo::first();

        return view('index', compact(
            'about',
            'visiMisi',
            'features',
            'galleries',
            'testimonials',
            'faqs',
            'contactInfo'
        ));
    }
}
