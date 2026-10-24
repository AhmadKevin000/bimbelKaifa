<?php

namespace Database\Seeders;

use App\Models\LandingPhoto;
use Illuminate\Database\Seeder;

class LandingPhotoSeeder extends Seeder
{
    /**
     * Every filename below must exist in public/images.
     *
     * The previous version still pointed at hero-siswa.png, rapor_pdf_mockup.png
     * and keunggulan3.png, all of which have been removed from the repository.
     * Those stale rows were what produced the "missing image" slots on the
     * landing page. Keep this list in sync with LandingPageController::PHOTO_DEFAULTS.
     */
    private const PHOTOS = [
        ['key' => 'logo',       'image_path' => 'Kaifa.png',                          'description' => 'Logo KAIFA'],
        ['key' => 'hero',       'image_path' => '01M5P4010XP8QH80WNBQQ6797J.jpg',     'description' => 'Hero Photo'],
        ['key' => 'about',      'image_path' => 'keunggulan1.png',                    'description' => 'About Photo'],
        ['key' => 'facility_1', 'image_path' => 'keunggulan2.png',                    'description' => 'Belajar dengan pendamping'],
        ['key' => 'facility_2', 'image_path' => '01KX4ZTP961DNFQK9BV5BBWDSF.jpeg',    'description' => 'Membaca buku'],
        ['key' => 'facility_3', 'image_path' => '01KTR0CJAG1QC2KP1GM0FA6XCR.jpeg',    'description' => 'Menulis dan tablet'],
        ['key' => 'facility_4', 'image_path' => '01KX51Q9ZBEX2H18GERBXWKV2X.jpeg',    'description' => 'Meja belajar'],
    ];

    public function run(): void
    {
        foreach (self::PHOTOS as $photo) {
            // Matched on `key` alone. Matching on key+image_path used to INSERT a
            // second row for the same slot whenever a filename changed, which left
            // the old broken row behind.
            LandingPhoto::updateOrCreate(
                ['key' => $photo['key']],
                array_merge($photo, ['is_active' => true])
            );
        }
    }
}
