@php
    /*
     * Program cards are grouped from the tarif_spp rows (program + jenjang + nominal + type).
     * Nothing here is hardcoded pricing: every number comes from the database.
     */
    $programGroups = collect($programs)
        ->filter(fn ($row) => $row->program !== null)
        ->groupBy(fn ($row) => $row->program->nama);

    /*
     * Descriptive bullet points that already existed in the previous landing page.
     *
     * Keyed by program name. A program without an entry shows no bullet list at
     * all rather than a generic filler list, so nothing is invented to pad a card.
     * The "laporan evaluasi" line was dropped from Reguler because the same claim
     * is already made once in the Fasilitas section.
     */
    $fiturProgram = [
        'calistung' => [
            'Belajar membaca, menulis & berhitung',
            'Metode belajar interaktif',
            'Pendekatan personal sesuai karakter anak',
            'Membangun rasa percaya diri anak',
        ],
        'reguler' => [
            'Pendampingan PR & tugas sekolah',
            'Persiapan ulangan harian, PTS & PAS',
            'Pendalaman konsep materi pelajaran',
        ],
        'tka' => [
            'Fokus penguatan Literasi & Numerasi (AKM)',
            'Latihan soal penalaran & logika dasar',
            'Persiapan seleksi masuk SMP/SMA favorit',
        ],
    ];

    $tints = ['bg-kf-blue-soft', 'bg-kf-yellow-soft', 'bg-kf-mint', 'bg-kf-lilac'];
    $hasPerMapel = collect($programs)->contains(fn ($row) => ($row->type ?? 'flat') === 'per_mapel');
@endphp

<section id="program" class="kf-section border-y border-kf-line bg-kf-cream-deep">
    <div class="kf-container">
        <div class="max-w-2xl">
            <p class="kf-eyebrow">Program &amp; Biaya</p>
            <h2 class="kf-h2 mt-4">Pilih program sesuai jenjang anak</h2>
            <p class="kf-lead mt-4">
                Setiap program dirancang untuk jenjang tertentu. Biaya di bawah ini diambil langsung dari
                data program KAIFA, jadi yang Anda lihat adalah tarif yang berlaku.
            </p>
        </div>

        @if ($programGroups->isEmpty())
            <div class="kf-card mt-10 max-w-xl">
                <h3 class="kf-h3">Informasi program sedang diperbarui</h3>
                <p class="mt-2 text-sm text-kf-ink-3">
                    Data program belum tersedia saat ini. Hubungi admin untuk informasi program dan biaya terbaru.
                </p>
                <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer"
                    class="kf-btn kf-btn--primary mt-5">
                    Tanya via WhatsApp
                </a>
            </div>
        @else
            <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($programGroups as $namaProgram => $rows)
                    @php
                        $tint = $tints[$loop->index % count($tints)];
                        $fiturList = $fiturProgram[strtolower($namaProgram)] ?? [];
                        $jenjangList = $rows
                            ->map(fn ($row) => $row->jenjang->nama ?? null)
                            ->filter()
                            ->unique()
                            ->values();

                        $waProgram = $wa(
                            'Halo Bimbel KAIFA! Saya tertarik untuk mendaftarkan anak saya di program '
                                . $namaProgram
                                . ($jenjangList->isNotEmpty() ? ' jenjang ' . $jenjangList->implode('/') : '')
                                . '. Boleh minta informasi jadwal dan cara pendaftarannya?'
                        );
                    @endphp

                    <article class="kf-card kf-card--hover flex h-full flex-col" data-reveal>
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="kf-h3">{{ $namaProgram }}</h3>
                            <span class="kf-icon {{ $tint }} text-kf-ink" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5V5.5Z" />
                                    <path d="M8 7h8M8 11h5" />
                                </svg>
                            </span>
                        </div>

                        @if ($jenjangList->isNotEmpty())
                            <ul class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($jenjangList as $jenjang)
                                    <li class="kf-chip">{{ $jenjang }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (! empty($fiturList))
                            <ul class="mt-5 flex flex-col gap-2.5">
                                @foreach ($fiturList as $fitur)
                                    <li class="kf-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M4 12.5l5 5L20 6.5" />
                                        </svg>
                                        <span>{{ $fitur }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- mb-6 guarantees breathing room above the button even when
                             the card has no spare height for mt-auto to absorb, which
                             is what happened to the one-row Calistung card on mobile. --}}
                        <div class="mb-6 mt-6 border-t border-kf-line pt-3">
                            <p class="text-xs font-semibold uppercase tracking-wider text-kf-ink-3">
                                SPP {{ $rows->count() > 1 ? 'per jenjang' : '' }}
                            </p>

                            <dl class="mt-1">
                                @foreach ($rows as $row)
                                    @php
                                        $isPerMapel = ($row->type ?? 'flat') === 'per_mapel';
                                        $namaJenjang = $row->jenjang->nama ?? null;
                                    @endphp
                                    <div class="kf-price-row">
                                        <dt class="text-sm font-medium text-kf-ink-2">
                                            {{ $namaJenjang ?? 'Program' }}
                                        </dt>
                                        {{-- Flex column so the unit always drops below
                                             the nominal and right-aligns with it. --}}
                                        <dd class="flex flex-col items-end text-right">
                                            @if ($row->nominal === null)
                                                <span class="text-sm font-semibold text-kf-ink-3">Hubungi admin</span>
                                            @else
                                                <span class="kf-price-value">
                                                    Rp {{ number_format((float) $row->nominal, 0, ',', '.') }}
                                                </span>
                                                @if ($isPerMapel)
                                                    <span class="kf-price-unit kf-price-unit--note">per mata pelajaran</span>
                                                @else
                                                    <span class="kf-price-unit">per bulan</span>
                                                @endif
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>

                        <a href="{{ $waProgram }}" target="_blank" rel="noopener noreferrer"
                            class="kf-btn kf-btn--outline kf-btn--block mt-auto">
                            Tanya program ini
                        </a>
                    </article>
                @endforeach
            </div>

            @if ($hasPerMapel)
                <p class="mt-6 flex items-start gap-2 text-sm text-kf-ink-3">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" aria-hidden="true" class="mt-1 flex-shrink-0">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 11v5M12 7.6v.1" />
                    </svg>
                    <span>Biaya bertanda <strong class="font-semibold text-kf-ink-2">per mata pelajaran</strong>
                        dihitung untuk setiap mata pelajaran yang diambil, bukan biaya bulanan tetap.</span>
                </p>
            @endif
        @endif
    </div>
</section>
