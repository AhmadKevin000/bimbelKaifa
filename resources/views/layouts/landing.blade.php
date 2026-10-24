<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="color-scheme" content="light">

    <title>@yield('title', 'KAIFA Tutoring Center | Bimbel Pre School hingga SMA')</title>
    <meta name="description"
        content="@yield('meta_description', 'KAIFA Tutoring Center menyediakan program bimbingan belajar untuk jenjang Pre School, SD, SMP, dan SMA dengan pendekatan belajar yang personal dan menyenangkan.')">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="KAIFA Tutoring Center">
    <meta property="og:title" content="@yield('title', 'KAIFA Tutoring Center | Bimbel Pre School hingga SMA')">
    <meta property="og:description"
        content="@yield('meta_description', 'Program bimbingan belajar untuk jenjang Pre School, SD, SMP, dan SMA dengan pendekatan belajar yang personal dan menyenangkan.')">
    <meta property="og:url" content="{{ url()->current() }}">
    {{-- Social preview uses the about photo (a real photograph) rather than the
         transparent hero cut-out, which reads poorly on social cards. --}}
    @php
        $ogImage = $photos['about'] ?? 'images/keunggulan1.png';
        if (! file_exists(public_path($ogImage))) {
            $ogImage = 'images/keunggulan1.png';
        }
    @endphp
    <meta property="og:image" content="{{ asset($ogImage) }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" href="{{ asset('images/Kaifa.png') }}">

    {{-- Fonts: Plus Jakarta Sans for display, Inter for body. Both with swap. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap">

    @vite(['resources/css/landing.css', 'resources/js/app.js'])

    @stack('head')
</head>

<body>
    <a href="#main" class="kf-skip">Langsung ke konten utama</a>

    @yield('content')

    @stack('scripts')
</body>

</html>
