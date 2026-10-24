@php
    // Strengths derived from the existing program data and the previous page copy.
    // Titles are unchanged; only the wording is tightened so the three cards read
    // with the same rhythm.
    $reasons = [
        [
            'title' => 'Program dipisah per jenjang',
            'text' => 'Materi Pre School, SD, SMP, dan SMA disusun terpisah agar sesuai dengan tahap belajar anak.',
            'icon' => 'M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4H20v13H6.5A2.5 2.5 0 0 0 4 19.5Zm0 0A2.5 2.5 0 0 0 6.5 22H20v-5',
        ],
        [
            'title' => 'Latihan soal & simulasi tes',
            'text' => 'Latihan soal dan simulasi tes untuk menguatkan Literasi dan Numerasi siswa.',
            'icon' => 'M9 3h6M12 3v2m-7 3h14M5 8v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8M9 13l2 2 4-4',
        ],
        [
            'title' => 'Fondasi membaca & berhitung',
            'text' => 'Untuk jenjang Pre School, anak diajak mengenal huruf dan angka lewat aktivitas yang menyenangkan.',
            'icon' => 'M12 6.5C10.5 5 8.5 4.5 6 4.5c-1 0-2 .1-3 .4v14c1-.3 2-.4 3-.4 2.5 0 4.5.5 6 2 1.5-1.5 3.5-2 6-2 1 0 2 .1 3 .4v-14c-1-.3-2-.4-3-.4-2.5 0-4.5.5-6 2Zm0 0v14',
        ],
    ];
@endphp

<section id="keunggulan" class="kf-section bg-kf-paper">
    <div class="kf-container">
        <div class="max-w-2xl">
            <p class="kf-eyebrow">Kenapa KAIFA</p>
            <h2 class="kf-h2 mt-4">Belajar yang mengikuti tahap anak</h2>
            <p class="kf-lead mt-4">
                Setiap jenjang punya kebutuhan berbeda. Karena itu materi, pendampingan, dan target belajar
                di KAIFA disesuaikan dengan tahap yang sedang dijalani siswa.
            </p>
        </div>

        {{--
            Featured banner. It used to be a tall card spanning two grid rows, which
            made it compete with the three reasons instead of leading them. Now it is
            a full-width horizontal band: text left, CTA right on lg, stacked below that.
        --}}
        <article class="relative mt-10 overflow-hidden rounded-[1.75rem] bg-kf-blue" data-reveal>
            <div class="kf-blob -right-16 -top-24 h-56 w-56 bg-white/10" aria-hidden="true"></div>

            <div
                class="relative flex flex-col gap-6 p-7 sm:p-9 lg:flex-row lg:items-center lg:justify-between lg:gap-12 lg:px-11 lg:py-9">
                <div class="min-w-0">
                    <span class="kf-chip kf-chip--onDark">Pendampingan</span>
                    <h3 class="mt-4 max-w-xl font-display text-2xl font-extrabold leading-tight text-white sm:text-3xl">
                        Dari tugas harian sampai ujian semester
                    </h3>
                    <p class="mt-3 max-w-xl text-[0.95rem] leading-relaxed text-white/85">
                        Siswa mendapat pendampingan untuk pekerjaan rumah, persiapan ulangan harian, PTS, dan PAS —
                        sehingga materi sekolah dan sesi bimbingan berjalan searah.
                    </p>
                </div>

                <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer"
                    class="kf-btn kf-btn--onDark shrink-0 self-start lg:self-center">
                    Konsultasi kebutuhan belajar
                </a>
            </div>
        </article>

        {{--
            Supporting cards: one column on phones, two from 640, three from 1024.
            Three columns at 768 squeezed the body copy to roughly 24 characters a
            line, so the tablet band keeps two columns and the third card spans the
            row in the horizontal variant.
        --}}
        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($reasons as $index => $reason)
                <article
                    class="kf-card kf-card--hover flex h-full flex-col sm:flex-row sm:gap-4 lg:flex-col lg:gap-0 {{ $loop->last ? 'sm:col-span-2 lg:col-span-1' : '' }}"
                    data-reveal style="--reveal-delay: {{ ($index + 1) * 70 }}ms">
                    <span class="kf-icon bg-kf-cream-deep text-kf-ink" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="{{ $reason['icon'] }}" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="mt-4 font-display text-base font-bold text-kf-ink sm:mt-0 lg:mt-4">
                            {{ $reason['title'] }}
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-kf-ink-3">{{ $reason['text'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
