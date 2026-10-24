<?php

namespace App\Http\Controllers;

use App\Models\LandingPhoto;
use App\Models\LandingSetting;
use App\Models\TarifSpp;

class LandingPageController extends Controller
{
    /**
     * Fallback image for each slot when the database has no active photo, or when
     * the stored file is no longer on disk.
     *
     * Every path here must exist in public/images. The old defaults pointed at
     * hero-siswa.png / rapor_pdf_mockup.png / keunggulan3.png, none of which are
     * on disk any more, which produced 404s on the public page.
     */
    private const PHOTO_DEFAULTS = [
        'logo' => 'images/Kaifa.png',
        'hero' => 'images/01M5P4010XP8QH80WNBQQ6797J.jpg',
        'about' => 'images/keunggulan1.png',
        'facility_1' => 'images/keunggulan2.png',
        'facility_2' => 'images/01KX4ZTP961DNFQK9BV5BBWDSF.jpeg',
        'facility_3' => 'images/01KTR0CJAG1QC2KP1GM0FA6XCR.jpeg',
        'facility_4' => 'images/01KX51Q9ZBEX2H18GERBXWKV2X.jpeg',
    ];

    public function index()
    {
        $dbPhotos = LandingPhoto::where('is_active', true)->pluck('image_path', 'key')->toArray();

        $dbPhotos = array_map(function (string $path) {
            return str_starts_with($path, 'images/') ? $path : 'images/'.$path;
        }, $dbPhotos);

        // Resolve each slot independently: the stored photo wins only while its
        // file still exists, otherwise the slot falls back to its own default.
        $photos = [];

        foreach (self::PHOTO_DEFAULTS as $key => $default) {
            $candidate = $dbPhotos[$key] ?? null;

            if ($candidate !== null && file_exists(public_path($candidate))) {
                $photos[$key] = $candidate;
            } elseif ($default !== null && file_exists(public_path($default))) {
                $photos[$key] = $default;
            }
        }

        // Ambil semua tarif SPP dengan relasi program & jenjang,
        // urutkan berdasarkan program_id agar urutan kartu konsisten.
        $programs = TarifSpp::with(['program', 'jenjang'])
            ->orderBy('program_id')
            ->get();

        $content = LandingSetting::content();

        return view('landing', compact('photos', 'programs', 'content'));
    }
}
