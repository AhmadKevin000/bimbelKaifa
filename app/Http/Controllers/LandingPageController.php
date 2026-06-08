<?php

namespace App\Http\Controllers;

use App\Models\LandingPhoto;

class LandingPageController extends Controller
{
    public function index()
    {
        $defaults = [
            'logo' => 'images/Kaifa.png',
            'hero' => 'images/hero-siswa.png',
            'about' => 'images/keunggulan1.png',
            'facility_1' => 'images/keunggulan2.png',
            'facility_2' => 'images/rapor_pdf_mockup.png',
            'facility_3' => 'images/keunggulan3.png',
            'facility_4' => 'images/hero-siswa.png',
        ];

        $dbPhotos = LandingPhoto::pluck('image_path', 'key')->toArray();

        $dbPhotos = array_map(function (string $path) {
            return str_starts_with($path, 'images/') ? $path : 'images/' . $path;
        }, $dbPhotos);

        $photos = array_merge($defaults, $dbPhotos);

        return view('landing', compact('photos'));
    }
}
