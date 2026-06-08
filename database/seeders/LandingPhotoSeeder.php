<?php

namespace Database\Seeders;

use App\Models\LandingPhoto;
use Illuminate\Database\Seeder;

class LandingPhotoSeeder extends Seeder
{
    public function run(): void
    {
        $photos = [
            ['key' => 'logo', 'image_path' => 'images/Kaifa.png', 'description' => 'Logo KAIFA'],
            ['key' => 'hero', 'image_path' => 'images/hero-siswa.png', 'description' => 'Hero Photo'],
            ['key' => 'about', 'image_path' => 'images/keunggulan1.png', 'description' => 'About Photo'],
            ['key' => 'facility_1', 'image_path' => 'images/keunggulan2.png', 'description' => 'Library'],
            ['key' => 'facility_2', 'image_path' => 'images/rapor_pdf_mockup.png', 'description' => 'Report Card'],
            ['key' => 'facility_3', 'image_path' => 'images/keunggulan3.png', 'description' => 'Guidance'],
            ['key' => 'facility_4', 'image_path' => 'images/hero-siswa.png', 'description' => 'Lounge'],
        ];

        foreach ($photos as $photo) {
            LandingPhoto::updateOrCreate(['key' => $photo['key']], $photo);
        }
    }
}
