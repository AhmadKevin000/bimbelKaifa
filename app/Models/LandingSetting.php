<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Single-row store for editable landing-page copy.
 *
 * DEFAULTS doubles as the seed for the admin form and as the fallback used by
 * the public page, so the landing page renders correctly even before an admin
 * ever opens the CMS (or if the table is missing on a fresh checkout).
 */
class LandingSetting extends Model
{
    protected $table = 'landing_settings';

    protected $fillable = [
        'hero_title',
        'hero_description',
        'about_description',
        'about_vision',
        'about_mission',
        'faqs',
        'process_steps',
        'contact_whatsapp',
        'contact_email',
        'contact_address',
        'contact_hours',
        'contact_instagram',
    ];

    protected $casts = [
        'faqs' => 'array',
        'process_steps' => 'array',
    ];

    /**
     * The `*…*` marker in a headline is rendered as the yellow highlight,
     * so the admin never has to write HTML.
     */
    public const DEFAULTS = [
        'hero_title' => 'Belajar lebih *percaya diri*, bertumbuh setiap hari.',
        'hero_description' => 'Temukan program belajar yang membantu siswa membangun pemahaman dan mengembangkan potensinya — dengan pendampingan yang personal dan suasana belajar yang menyenangkan.',
        'about_description' => 'KAIFA adalah pusat bimbingan belajar yang lahir dari semangat untuk memberikan pendidikan berkualitas yang personal dan menyenangkan. Kami percaya setiap anak memiliki potensi unik yang perlu diasah dengan metode yang tepat.',
        'about_vision' => 'Menjadi pusat keunggulan akademik yang mencetak generasi cerdas, berkarakter, dan siap bersaing di tingkat global.',
        'about_mission' => 'Mendampingi setiap siswa mencapai prestasi terbaiknya melalui pendekatan humanis dan kurikulum adaptif.',
        'faqs' => [
            [
                'question' => 'Berapa rincian biaya bimbingan di KAIFA?',
                'answer' => 'Biaya bimbingan berbeda untuk setiap program dan jenjang. Rincian tarif yang berlaku ditampilkan pada bagian Program & Biaya di halaman ini. Untuk kombinasi program yang belum tercantum, silakan hubungi admin melalui WhatsApp.',
            ],
            [
                'question' => 'Apakah ada pembatasan jumlah siswa per kelas?',
                'answer' => 'Ya. Demi efektivitas belajar, jumlah siswa per kelas dibatasi maksimal 10 siswa agar setiap anak mendapat perhatian penuh dari tutor.',
            ],
            [
                'question' => 'Bagaimana jadwal belajar di KAIFA?',
                'answer' => 'Sesi belajar tersedia pada Senin sampai Sabtu, 13.30 – 19.30 WIB, dan terbagi ke beberapa slot waktu. Silakan hubungi admin untuk memilih slot yang tidak bertabrakan dengan jadwal sekolah.',
            ],
            [
                'question' => 'Apa perbedaan program Reguler dan TKA?',
                'answer' => 'Program Reguler berfokus pada pendampingan PR dan pelajaran sekolah sehari-hari. Sedangkan TKA (Tes Kemampuan Akademik) dirancang khusus untuk penguatan Literasi dan Numerasi (AKM) serta persiapan tes masuk sekolah favorit.',
            ],
        ],
        'process_steps' => [
            [
                'title' => 'Mengenali kebutuhan belajar',
                'description' => 'Orang tua dan siswa menyampaikan kondisi belajar saat ini — materi yang dirasa sulit, target, serta waktu belajar yang tersedia.',
            ],
            [
                'title' => 'Pendampingan belajar & latihan',
                'description' => 'Siswa belajar bersama tutor sesuai jenjang dan program yang dipilih, disertai latihan soal untuk menguatkan pemahaman.',
            ],
            [
                'title' => 'Evaluasi & tindak lanjut',
                'description' => 'Perkembangan belajar ditinjau bersama, lalu materi yang masih perlu diperkuat dibahas untuk sesi berikutnya.',
            ],
        ],
        'contact_whatsapp' => '6281939197272',
        'contact_email' => 'temanbelajarkaifa@gmail.com',
        'contact_address' => 'Jl. Brigjen Katamso No. 195, Gedog, Sananwetan, Kota Blitar',
        'contact_hours' => 'Senin – Sabtu, 13.30 – 19.30 WIB',
        'contact_instagram' => 'https://www.instagram.com/temankaifa?igsh=MWJ3bGJ6ZGEzY2V3dw==',
    ];

    /**
     * The settings row, created with defaults on first use (admin only).
     */
    public static function current(): ?self
    {
        try {
            return static::query()->firstOrCreate(['id' => 1], static::DEFAULTS);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Read-only accessor for the public page. Never writes during a GET.
     *
     * @return array<string, mixed>
     */
    public static function content(): array
    {
        try {
            $stored = static::query()->first()?->only(array_keys(static::DEFAULTS)) ?? [];
        } catch (Throwable) {
            $stored = [];
        }

        $content = static::DEFAULTS;

        foreach ($stored as $key => $value) {
            if (is_array($value)) {
                if ($value !== []) {
                    $content[$key] = $value;
                }

                continue;
            }

            if (is_string($value) && trim($value) !== '') {
                $content[$key] = $value;
            }
        }

        return $content;
    }

    /**
     * Normalise an Indonesian phone number into the digits-only form wa.me expects.
     */
    public static function normaliseWhatsapp(?string $raw): string
    {
        $digits = preg_replace('/\D+/', '', (string) $raw) ?? '';

        if ($digits === '') {
            return self::DEFAULTS['contact_whatsapp'];
        }

        if (str_starts_with($digits, '0')) {
            return '62'.substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62'.$digits;
        }

        return $digits;
    }
}
