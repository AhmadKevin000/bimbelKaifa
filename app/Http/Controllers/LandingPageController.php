<?php

namespace App\Http\Controllers;

use App\Models\LandingPhoto;

class LandingPageController extends Controller
{
    public function index()
    {
        $defaults = [
            'logo'       => 'Kaifa.png',
            'hero'       => 'hero-siswa.png',
            'about'      => 'keunggulan1.png',
            'facility_1' => 'keunggulan2.png',
            'facility_2' => 'rapor_pdf_mockup.png',
            'facility_3' => 'keunggulan3.png',
            'facility_4' => 'hero-siswa.png',
        ];

        $dbPhotos = LandingPhoto::where('is_active', true)->pluck('image_path', 'key')->toArray();

        $dbPhotos = array_map(function (string $path) {
            return str_starts_with($path, 'images/') ? $path : 'images/' . $path;
        }, $dbPhotos);

        $photos = array_merge($defaults, $dbPhotos);

        return view('landing', compact('photos'));
    }
}
