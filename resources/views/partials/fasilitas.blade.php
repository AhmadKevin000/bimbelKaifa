@php
    /*
     * Facilities keep using the admin-managed landing_photos slots (facility_1 … facility_4).
     *
     * A slot is only rendered when its file actually exists and is not already
     * used by an earlier slot, so the gallery never shows a broken image or the
     * same photo twice. The grid counts what resolved and adapts, so removing or
     * adding a photo in the admin panel never leaves a hole.
     */
    $slotAlt = [
        'facility_1' => 'Ilustrasi anak dan pendamping belajar bersama memakai tablet',
        'facility_2' => 'Ilustrasi siswa membaca buku pelajaran',
        'facility_3' => 'Ilustrasi anak menulis sambil memakai tablet',
        'facility_4' => 'Ilustrasi meja belajar dengan laptop, kalkulator, dan catatan',
    ];

    $gallery = [];
    $used = [];

    foreach ($slotAlt as $key => $alt) {
        $path = $photos[$key] ?? null;

        if ($path === null || ! file_exists(public_path($path)) || in_array($path, $used, true)) {
            continue;
        }

        $used[] = $path;
        $gallery[] = ['src' => $path, 'alt' => $alt];
    }

    // Literal class strings so Tailwind's scanner can see every variant.
    // Two-up on phones and tablets, four-across on desktop. Measured at 1440:
    // a full-width 2x2 gave 620x413 photos and a 1379px section against a 529px
    // hero, and even a max-w-4xl 2x2 still came to 1198px — taller than the
    // two-large-photos gallery this replaced (1027px), which is the exact problem
    // the redesign was meant to fix. Four-across lands at 781px.
    $galleryCols = match (count($gallery)) {
        1 => 'mx-auto max-w-md',
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 lg:grid-cols-3',
        default => 'grid-cols-2 lg:grid-cols-4',
    };

    // Existing facility copy from the previous landing page, preserved.
    $facilities = [
        [
            'title' => 'Laporan evaluasi berkala',
            'text' => 'Pantau perkembangan dan nilai anak melalui laporan rutin yang transparan.',
            'icon' => 'M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm7 1v5h5M9 13h6M9 17h6',
        ],
        [
            'title' => 'Suasana homey & aman',
            'text' => 'Ruang belajar tenang dan bersih layaknya di rumah sendiri agar anak tidak tegang.',
            'icon' => 'M3 10.5 12 3l9 7.5M5 9.5V21h14V9.5M9.5 21v-6h5v6',
        ],
        [
            'title' => 'Pengajar sabar & ramah',
            'text' => 'Tutor telaten yang mengedepankan kedekatan emosional dengan setiap anak.',
            'icon' => 'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M12 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z',
        ],
        [
            'title' => 'Kelompok belajar kecil',
            'text' => 'Kapasitas kelas dibatasi agar setiap anak mendapat perhatian penuh dari tutor.',
            'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 7a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm14 14v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8',
        ],
    ];
@endphp

<section id="fasilitas" class="kf-section">
    <div class="kf-container">
        <div class="max-w-2xl">
            <p class="kf-eyebrow">Fasilitas</p>
            <h2 class="kf-h2 mt-4">Lingkungan belajar yang kondusif</h2>
            <p class="kf-lead mt-4">
                Kami percaya suasana yang nyaman, aman, dan kekeluargaan adalah kunci agar anak lebih fokus
                dan betah belajar.
            </p>
        </div>

        @if (! empty($gallery))
            {{-- Shorter 3:2 crop keeps four photos from pushing the section taller
                 than the hero, which a 4:3 grid of the same width did. --}}
            <ul class="mt-10 grid gap-4 {{ $galleryCols }}">
                @foreach ($gallery as $index => $photo)
                    <li data-reveal style="--reveal-delay: {{ $index * 60 }}ms">
                        <figure class="overflow-hidden rounded-[1.25rem] border border-kf-line bg-kf-cream-deep">
                            <img src="{{ asset($photo['src']) }}" alt="{{ $photo['alt'] }}" loading="lazy"
                                decoding="async"
                                class="aspect-[3/2] w-full scale-[1.08] object-cover object-center transition-transform duration-500 hover:scale-[1.12]">
                        </figure>
                    </li>
                @endforeach
            </ul>

            <p class="mt-4 text-sm text-kf-ink-3">
                Foto ilustrasi suasana belajar, bukan dokumentasi ruang KAIFA.
            </p>
        @endif

        <ul class="mt-12 grid gap-x-8 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($facilities as $facility)
                <li class="flex items-start gap-3.5">
                    <span class="kf-icon bg-kf-yellow-soft text-kf-ink" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="{{ $facility['icon'] }}" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-display text-[0.95rem] font-bold leading-snug text-kf-ink">
                            {{ $facility['title'] }}
                        </h3>
                        <p class="mt-1 text-sm leading-relaxed text-kf-ink-3">{{ $facility['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
