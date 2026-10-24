@php
    $logoPath = $photos['logo'] ?? null;

    if ($logoPath === null || ! file_exists(public_path($logoPath))) {
        $logoPath = 'images/Kaifa.png';
    }

    $footerLinks = [
        ['href' => '#tentang', 'label' => 'Tentang KAIFA'],
        ['href' => '#program', 'label' => 'Program & Biaya'],
        ['href' => '#keunggulan', 'label' => 'Keunggulan'],
        ['href' => '#fasilitas', 'label' => 'Fasilitas'],
        ['href' => '#faq', 'label' => 'FAQ'],
    ];
@endphp

<footer class="border-t border-kf-line bg-kf-cream-deep">
    <div class="kf-container">
        <h2 class="sr-only">Informasi KAIFA Tutoring Center</h2>

        <div class="grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-12 lg:gap-8 lg:py-14">
            {{-- Brand --}}
            <div class="lg:col-span-4">
                <a href="#hero" class="inline-block" aria-label="KAIFA Tutoring Center — ke bagian atas halaman">
                    <img src="{{ asset($logoPath) }}" alt="KAIFA Tutoring Center" width="536" height="296"
                        class="h-10 w-auto" loading="lazy" decoding="async">
                </a>
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-kf-ink-3">
                    Teman belajar untuk jenjang Pre School, SD, SMP, dan SMA — dengan pendampingan yang
                    personal dan suasana belajar yang menyenangkan.
                </p>

                <ul class="mt-5 flex gap-2.5">
                    <li>
                        <a href="{{ $content['contact_instagram'] }}" target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-kf-line bg-kf-paper text-kf-ink-2 transition-colors hover:border-kf-ink hover:text-kf-ink"
                            aria-label="Instagram KAIFA">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                <circle cx="12" cy="12" r="3.6" />
                                <path d="M17.2 6.8v.01" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $content['contact_email'] }}"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-kf-line bg-kf-paper text-kf-ink-2 transition-colors hover:border-kf-ink hover:text-kf-ink"
                            aria-label="Kirim email ke KAIFA">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3.5 7 8.5 6 8.5-6" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-kf-line bg-kf-paper text-kf-ink-2 transition-colors hover:border-kf-ink hover:text-kf-ink"
                            aria-label="Hubungi KAIFA via WhatsApp">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.23 8.23Z" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Navigation --}}
            <div class="lg:col-span-2">
                <h3 class="font-display text-sm font-bold text-kf-ink">Navigasi</h3>
                <ul class="mt-3 flex flex-col gap-1">
                    @foreach ($footerLinks as $link)
                        <li>
                            {{-- py-1 keeps each row at a 24px+ touch target (WCAG 2.2 target size) --}}
                            <a href="{{ $link['href'] }}"
                                class="inline-block py-1 text-sm text-kf-ink-3 transition-colors hover:text-kf-blue">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div class="lg:col-span-3">
                <h3 class="font-display text-sm font-bold text-kf-ink">Kontak &amp; Alamat</h3>
                <ul class="mt-4 flex flex-col gap-3 text-sm text-kf-ink-3">
                    <li class="flex items-start gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            class="mt-0.5 flex-shrink-0">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 1 1 16 0Z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span>{{ $content['contact_address'] }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            class="mt-0.5 flex-shrink-0">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="m3.5 7 8.5 6 8.5-6" />
                        </svg>
                        <a href="mailto:{{ $content['contact_email'] }}"
                            class="py-0.5 transition-colors hover:text-kf-blue">{{ $content['contact_email'] }}</a>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            class="mt-0.5 flex-shrink-0">
                            <path d="M5 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L15 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 3 5.2 2 2 0 0 1 5 3Z" />
                        </svg>
                        <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer"
                            class="py-0.5 transition-colors hover:text-kf-blue">WhatsApp KAIFA</a>
                    </li>
                </ul>
            </div>

            {{-- Hours --}}
            <div class="lg:col-span-3">
                <h3 class="font-display text-sm font-bold text-kf-ink">Jam Operasional</h3>
                <dl class="mt-4 flex flex-col gap-3 text-sm">
                    <div>
                        <dt class="font-semibold text-kf-ink-2">Jam belajar</dt>
                        <dd class="text-kf-ink-3">{{ $content['contact_hours'] }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-kf-ink-2">Minggu</dt>
                        <dd class="text-kf-ink-3">Tutup</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="border-t border-kf-line py-6">
            <p class="text-sm text-kf-ink-3">
                &copy; {{ date('Y') }} KAIFA Tutoring Center. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </div>
</footer>
