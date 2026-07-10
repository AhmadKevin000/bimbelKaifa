<?php

namespace App\Http\Controllers;

use App\Models\LandingPhoto;
use App\Models\TarifSpp;

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

        // Ambil semua tarif SPP dengan relasi program & jenjang,
        // urutkan berdasarkan program_id agar urutan kartu konsisten.
        $programs = TarifSpp::with(['program', 'jenjang'])
            ->orderBy('program_id')
            ->get();

        return view('landing', compact('photos', 'programs'));
    }
}
