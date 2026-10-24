@php
    $heroPath = $photos['hero'] ?? null;

    if ($heroPath === null || ! file_exists(public_path($heroPath))) {
        $heroPath = 'images/01M5P4010XP8QH80WNBQQ6797J.jpg';
    }

    // Real intrinsic size keeps the browser from reflowing while the photo loads.
    $heroSize = @getimagesize(public_path($heroPath)) ?: [1200, 630];

    /*
     * The admin writes the headline as plain text; *…* marks the yellow highlight.
     * Escaping first means no HTML from the CMS can ever be injected.
     */
    $heroTitle = preg_replace(
        '/\*(.+?)\*/u',
        '<span class="kf-mark">$1</span>',
        e($content['hero_title'])
    );
@endphp

<section id="hero" class="relative overflow-hidden">
    {{-- Decorative shapes: kept behind content and out of the a11y tree --}}
    <div class="kf-blob -left-24 -top-24 h-72 w-72 bg-kf-yellow-soft opacity-70" aria-hidden="true"></div>
    <div class="kf-blob -right-16 top-40 h-64 w-64 bg-kf-lilac opacity-60" aria-hidden="true"></div>

    <div class="kf-container relative z-10">
        <div class="grid items-center gap-10 py-10 md:py-14 lg:grid-cols-12 lg:gap-10 lg:py-16">
            {{-- Copy --}}
            <div class="lg:col-span-7">
                <p class="kf-chip">
                    <span class="inline-block h-2 w-2 rounded-full bg-kf-blue" aria-hidden="true"></span>
                    Bimbel KAIFA · Teman Belajar
                </p>

                <h1 class="kf-h1 mt-5">{!! $heroTitle !!}</h1>

                <p class="kf-lead mt-5 max-w-xl">
                    {{ $content['hero_description'] }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ $waRegister }}" target="_blank" rel="noopener noreferrer"
                        class="kf-btn kf-btn--primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.23 8.23Z" />
                        </svg>
                        Daftar via WhatsApp
                    </a>

                    <a href="#program" class="kf-btn kf-btn--outline">
                        Lihat Program
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 5v14M5 12l7 7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Image --}}
            <div class="relative lg:col-span-5">
                <div class="kf-blob -bottom-6 -left-6 h-32 w-32 bg-kf-yellow opacity-80" aria-hidden="true"></div>
                <div class="kf-blob -right-4 -top-4 h-24 w-24 bg-kf-mint" aria-hidden="true"></div>

                {{--
                    The photo is landscape (1.9:1), so the card follows the photo
                    instead of forcing it into a tall portrait box. 16:10 crops only
                    a few pixels from each side, which keeps every face in frame.
                --}}
                <div class="relative overflow-hidden rounded-[2rem] border border-kf-line bg-kf-blue-soft">
                    <img src="{{ asset($heroPath) }}" alt="Suasana belajar siswa di ruang baca"
                        width="{{ $heroSize[0] }}" height="{{ $heroSize[1] }}" fetchpriority="high" decoding="async"
                        class="aspect-[16/9] w-full object-cover object-center sm:aspect-[16/10]">
                </div>

                <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer"
                    class="mt-4 flex items-center gap-3 rounded-2xl border border-kf-line bg-kf-paper px-4 py-3 shadow-[0_16px_40px_-24px_rgba(22,24,42,0.5)] transition-transform hover:-translate-y-0.5 sm:absolute sm:-bottom-5 sm:left-4 sm:mt-0">
                    <span class="kf-icon bg-kf-mint text-kf-ink" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.4 8.4 0 0 1-9 8.4L3 21l1.1-3.3A8.4 8.4 0 1 1 21 11.5Z" />
                        </svg>
                    </span>
                    <span class="text-sm leading-tight">
                        <span class="block font-display font-bold text-kf-ink">Tanya jadwal &amp; biaya</span>
                        <span class="text-kf-ink-3">dibalas langsung via WhatsApp</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
