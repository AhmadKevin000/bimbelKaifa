@extends('layouts.landing')

@php
    /*
     * Single source of truth for the KAIFA WhatsApp contact, now editable from
     * the admin panel (Konten Halaman Depan → Kontak).
     *
     * The legacy short link (https://wa.link/bmd9s5) redirects to this number but
     * drops any ?text= parameter, so prefilled messages are built with wa.me here.
     */
    $waNumber = \App\Models\LandingSetting::normaliseWhatsapp($content['contact_whatsapp'] ?? null);

    $wa = fn (string $message): string => 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($message);

    $waRegister = $wa(
        'Halo Bimbel KAIFA! Saya tertarik untuk mendaftarkan anak saya. Boleh minta informasi mengenai program belajar, jadwal, dan cara pendaftarannya?'
    );

    $waConsult = $wa(
        'Halo Bimbel KAIFA! Saya ingin berkonsultasi mengenai program belajar yang tersedia. Boleh minta informasi lebih lanjut?'
    );

    $navLinks = [
        ['href' => '#tentang', 'label' => 'Tentang'],
        ['href' => '#program', 'label' => 'Program'],
        ['href' => '#keunggulan', 'label' => 'Keunggulan'],
        ['href' => '#fasilitas', 'label' => 'Fasilitas'],
        ['href' => '#faq', 'label' => 'FAQ'],
    ];
@endphp

@section('content')
    @include('partials.navbar')

    <main id="main">
        @include('partials.hero')
        @include('partials.about')
        @include('partials.program')
        @include('partials.why')
        @include('partials.fasilitas')
        @include('partials.proses')
        @include('partials.faq')
        @include('partials.cta')
    </main>

    @include('partials.footer')

    {{-- Floating WhatsApp: appears after the hero so it never covers the primary CTA --}}
    <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer" class="kf-float"
        data-float-wa data-visible="false" aria-label="Hubungi KAIFA via WhatsApp">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path
                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.23 8.23Zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.15-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.16.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.65.31-.23.25-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.65 4.2 3.71.59.25 1.05.4 1.4.51.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.22-.17-.47-.29Z" />
        </svg>
    </a>
@endsection
