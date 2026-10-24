@php
    $logoPath = $photos['logo'] ?? 'images/Kaifa.png';
    if (! file_exists(public_path($logoPath))) {
        $logoPath = 'images/Kaifa.png';
    }
@endphp

<header class="kf-header" data-header>
    <div class="kf-container">
        <div class="flex items-center justify-between gap-4" style="height: var(--kf-header-h);">
            <a href="#hero" class="flex-shrink-0" aria-label="KAIFA Tutoring Center — ke bagian atas halaman">
                <img src="{{ asset($logoPath) }}" alt="KAIFA Tutoring Center" width="536" height="296"
                    class="h-9 w-auto md:h-11" fetchpriority="high">
            </a>

            <nav aria-label="Navigasi utama" class="hidden lg:block">
                <ul class="flex items-center gap-7">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="kf-navlink">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ $waRegister }}" target="_blank" rel="noopener noreferrer"
                    class="kf-btn kf-btn--primary kf-btn--sm hidden sm:inline-flex">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path
                            d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.23 8.23Z" />
                    </svg>
                    Daftar via WhatsApp
                </a>

                <button type="button" class="kf-navtoggle lg:hidden" data-nav-toggle aria-expanded="false"
                    aria-controls="nav-drawer" aria-label="Buka menu navigasi">
                    <svg data-nav-icon="open" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg data-nav-icon="close" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" hidden>
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div id="nav-drawer" class="kf-drawer lg:hidden" data-nav-drawer hidden>
        <nav aria-label="Navigasi seluler">
            <ul>
                @foreach ($navLinks as $link)
                    <li>
                        <a href="{{ $link['href'] }}" class="kf-drawer-link" data-nav-link>
                            {{ $link['label'] }}
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" aria-hidden="true">
                                <path d="M9 6l6 6-6 6" />
                            </svg>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="mt-6 flex flex-col gap-3">
            <a href="{{ $waRegister }}" target="_blank" rel="noopener noreferrer" class="kf-btn kf-btn--primary kf-btn--block">
                Daftar via WhatsApp
            </a>
            <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer" class="kf-btn kf-btn--quiet kf-btn--block">
                Konsultasi Program
            </a>
        </div>

        <p class="mt-6 text-sm text-kf-ink-3">
            {{ $content['contact_hours'] }}
        </p>
    </div>
</header>

<noscript>
    <style>
        .kf-navtoggle {
            display: none;
        }
    </style>
    <nav aria-label="Navigasi" class="kf-container pb-4 lg:hidden">
        <ul class="flex flex-wrap gap-x-5 gap-y-2">
            @foreach ($navLinks as $link)
                <li><a href="{{ $link['href'] }}" class="kf-navlink">{{ $link['label'] }}</a></li>
            @endforeach
            <li><a href="{{ $waRegister }}" class="kf-navlink">Daftar via WhatsApp</a></li>
        </ul>
    </nav>
</noscript>
