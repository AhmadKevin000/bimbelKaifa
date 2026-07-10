<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KAIFA Tutoring Center | Bimbel Terbaik di Malang</title>
    <meta name="description" content="KAIFA Tutoring Center — bimbingan belajar intensif dengan kurikulum terpersonalisasi untuk membantu siswa menaklukkan UTBK, ujian PTN, dan sekolah kedinasan di Malang.">

    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter as SF Pro substitute for non-Apple platforms -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           APPLE DESIGN SYSTEM — KAIFA Landing
           Source: DESIGN.md (Apple-design-analysis)
        ============================================================ */

        /* --- Font Stack --- */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: "SF Pro Text", "Inter", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 17px;
            font-weight: 400;
            line-height: 1.47;
            letter-spacing: -0.374px;
            color: #1d1d1f;
            background-color: #ffffff;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* --- Typography Tokens --- */
        .t-hero {
            font-family: "SF Pro Display", "Inter", system-ui, -apple-system, sans-serif;
            font-size: clamp(34px, 5vw, 56px);
            font-weight: 600;
            line-height: 1.07;
            letter-spacing: -0.28px;
        }
        .t-display-lg {
            font-family: "SF Pro Display", "Inter", system-ui, -apple-system, sans-serif;
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 600;
            line-height: 1.1;
            letter-spacing: 0px;
        }
        .t-display-md {
            font-family: "SF Pro Text", "Inter", system-ui, -apple-system, sans-serif;
            font-size: 34px;
            font-weight: 600;
            line-height: 1.47;
            letter-spacing: -0.374px;
        }
        .t-lead {
            font-family: "SF Pro Display", "Inter", system-ui, -apple-system, sans-serif;
            font-size: clamp(19px, 2.5vw, 28px);
            font-weight: 400;
            line-height: 1.14;
            letter-spacing: 0.196px;
        }
        .t-lead-airy {
            font-family: "SF Pro Text", "Inter", system-ui, -apple-system, sans-serif;
            font-size: clamp(17px, 2vw, 24px);
            font-weight: 300;
            line-height: 1.5;
            letter-spacing: 0px;
        }
        .t-tagline {
            font-family: "SF Pro Display", "Inter", system-ui, -apple-system, sans-serif;
            font-size: 21px;
            font-weight: 600;
            line-height: 1.19;
            letter-spacing: 0.231px;
        }
        .t-body {
            font-size: 17px;
            font-weight: 400;
            line-height: 1.47;
            letter-spacing: -0.374px;
        }
        .t-body-strong {
            font-size: 17px;
            font-weight: 600;
            line-height: 1.24;
            letter-spacing: -0.374px;
        }
        .t-caption {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.43;
            letter-spacing: -0.224px;
        }
        .t-caption-strong {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.29;
            letter-spacing: -0.224px;
        }
        .t-nav-link {
            font-size: 12px;
            font-weight: 400;
            line-height: 1.0;
            letter-spacing: -0.12px;
        }
        .t-fine-print {
            font-size: 12px;
            font-weight: 400;
            line-height: 1.0;
            letter-spacing: -0.12px;
        }
        .t-button-large {
            font-size: 18px;
            font-weight: 300;
            line-height: 1.0;
            letter-spacing: 0px;
        }
        .t-dense-link {
            font-size: 17px;
            font-weight: 400;
            line-height: 2.41;
            letter-spacing: 0px;
        }

        /* --- Color Tokens --- */
        :root {
            --c-primary: #0066cc;
            --c-primary-focus: #0071e3;
            --c-primary-on-dark: #2997ff;
            --c-ink: #1d1d1f;
            --c-ink-muted-80: #333333;
            --c-ink-muted-48: #7a7a7a;
            --c-body-muted: #cccccc;
            --c-canvas: #ffffff;
            --c-canvas-parchment: #f5f5f7;
            --c-surface-pearl: #fafafc;
            --c-surface-tile-1: #272729;
            --c-hairline: #e0e0e0;
            --c-divider-soft: #f0f0f0;
            --c-surface-black: #000000;
        }

        /* --- Global Nav (Apple global-nav) --- */
        #global-nav {
            background-color: rgba(0, 0, 0, 0.85);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            height: 44px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 50;
        }
        #global-nav a {
            color: rgba(255,255,255,0.85);
            transition: color 0.15s;
        }
        #global-nav a:hover { color: #ffffff; }

        /* --- Buttons --- */
        .btn-primary {
            background-color: var(--c-primary);
            color: #ffffff;
            font-size: 17px;
            font-weight: 400;
            line-height: 1.47;
            letter-spacing: -0.374px;
            border-radius: 9999px;
            padding: 11px 22px;
            display: inline-block;
            transition: background-color 0.15s, transform 0.1s;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover { background-color: var(--c-primary-focus); }
        .btn-primary:active { transform: scale(0.95); }

        .btn-primary-lg {
            background-color: var(--c-primary);
            color: #ffffff;
            font-size: 18px;
            font-weight: 300;
            line-height: 1.0;
            letter-spacing: 0px;
            border-radius: 9999px;
            padding: 14px 28px;
            display: inline-block;
            transition: background-color 0.15s, transform 0.1s;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-primary-lg:hover { background-color: var(--c-primary-focus); }
        .btn-primary-lg:active { transform: scale(0.95); }

        .btn-secondary-pill {
            background-color: transparent;
            color: var(--c-primary);
            font-size: 17px;
            font-weight: 400;
            line-height: 1.47;
            letter-spacing: -0.374px;
            border-radius: 9999px;
            padding: 11px 22px;
            display: inline-block;
            border: 1px solid var(--c-primary);
            transition: background-color 0.15s, transform 0.1s;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-secondary-pill:hover { background-color: rgba(0, 102, 204, 0.06); }
        .btn-secondary-pill:active { transform: scale(0.95); }

        /* --- Tiles --- */
        .tile-white { background-color: var(--c-canvas); }
        .tile-parchment { background-color: var(--c-canvas-parchment); }
        .tile-dark { background-color: var(--c-surface-tile-1); }

        /* --- Store Utility Card --- */
        .utility-card {
            background-color: var(--c-canvas);
            border: 1px solid var(--c-hairline);
            border-radius: 18px;
            padding: 24px;
        }

        /* --- Product Image Shadow (the ONLY shadow in the system) --- */
        .product-shadow {
            box-shadow: rgba(0, 0, 0, 0.22) 3px 5px 30px 0px;
        }

        /* --- Hairline borders --- */
        .hairline { border: 1px solid var(--c-hairline); }
        .hairline-top { border-top: 1px solid var(--c-hairline); }
        .hairline-bottom { border-bottom: 1px solid var(--c-hairline); }

        /* --- Section spacing --- */
        .section-pad { padding-top: 80px; padding-bottom: 80px; }
        .section-pad-sm { padding-top: 48px; padding-bottom: 48px; }

        /* --- Max widths --- */
        .container-content {
            max-width: 980px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 22px;
            padding-right: 22px;
        }
        .container-wide {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 22px;
            padding-right: 22px;
        }

        /* --- Text colors --- */
        .text-ink { color: var(--c-ink); }
        .text-ink-muted { color: var(--c-ink-muted-48); }
        .text-primary-blue { color: var(--c-primary); }
        .text-on-dark { color: #ffffff; }
        .text-muted-dark { color: var(--c-body-muted); }
        .text-sky { color: var(--c-primary-on-dark); }

        /* --- Mobile nav --- */
        #mobile-drawer {
            background-color: rgba(0,0,0,0.95);
            display: none;
        }
        #mobile-drawer.open { display: flex; }

        /* --- Featured badge --- */
        .badge-blue {
            display: inline-block;
            background-color: var(--c-primary);
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            border-radius: 9999px;
            padding: 4px 12px;
        }

        /* --- Stat cards in hero --- */
        .stat-chip {
            background-color: rgba(255,255,255,0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 14px;
            padding: 14px 20px;
        }

        /* --- FAQ accordion --- */
        details summary { list-style: none; }
        details summary::-webkit-details-marker { display: none; }
        details[open] summary .faq-icon { transform: rotate(180deg); }
        .faq-icon { transition: transform 0.25s ease; }

        /* --- Testimonial slider --- */
        #slider-track { transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); }

        /* --- Program card hover --- */
        .program-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .program-card:hover {
            transform: translateY(-4px);
            box-shadow: rgba(0,0,0,0.08) 0 8px 24px;
        }

        /* --- Social icons --- */
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            border: 1px solid var(--c-hairline);
            color: var(--c-ink-muted-48);
            transition: color 0.15s, border-color 0.15s;
            text-decoration: none;
        }
        .social-link:hover { color: var(--c-primary); border-color: var(--c-primary); }

        /* --- Facility icon container --- */
        .facility-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            border: 1px solid var(--c-hairline);
            background-color: var(--c-canvas);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--c-primary);
        }

        /* --- Checklist item --- */
        .check-item { display: flex; align-items: flex-start; gap: 12px; }
        .check-dot {
            width: 20px;
            height: 20px;
            border-radius: 9999px;
            background-color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* --- Responsive tweaks --- */
        @media (max-width: 640px) {
            .t-hero { font-size: 34px; }
            .t-display-lg { font-size: 28px; }
            .section-pad { padding-top: 56px; padding-bottom: 56px; }
        }
        @media (max-width: 419px) {
            .t-hero { font-size: 28px; }
            .t-display-lg { font-size: 24px; }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    @include('partials.navbar')

    <main style="padding-top: 44px;">
        <!-- HERO -->
        @include('partials.hero')

        <!-- ABOUT -->
        @include('partials.about')

        <!-- PROGRAMS -->
        @include('partials.program')

        <!-- FACILITIES -->
        @include('partials.fasilitas')

        <!-- FAQ -->
        @include('partials.faq')

        <!-- TESTIMONIALS -->
        @include('partials.testimoni')

        <!-- CTA -->
        @include('partials.cta')
    </main>

    <!-- FOOTER -->
    @include('partials.footer')
    <!-- ============================================================
         JAVASCRIPT — Nav toggle & Testimonial slider
    ============================================================ -->
    <script>
        /* ---- Mobile nav toggle ---- */
        (function () {
            const btn = document.getElementById('mobile-menu-button');
            const drawer = document.getElementById('mobile-drawer');
            if (!btn || !drawer) return;

            btn.addEventListener('click', function () {
                const open = drawer.classList.toggle('open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                const icon = btn.querySelector('.material-symbols-outlined');
                if (icon) icon.textContent = open ? 'close' : 'menu';
            });

            // Close drawer when a link inside is clicked
            drawer.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    drawer.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                    const icon = btn.querySelector('.material-symbols-outlined');
                    if (icon) icon.textContent = 'menu';
                });
            });
        })();

        /* ---- Testimonial slider ---- */
        document.addEventListener('DOMContentLoaded', function() {
            var currentSlide = 0;
            var totalSlides = 3;

            window.moveSlider = function(index) {
                currentSlide = index;
                var track = document.getElementById('slider-track');
                if (track) {
                    track.style.transform = 'translateX(-' + (index * 100) + '%)';
                }
                // Update dots
                for (var i = 0; i < totalSlides; i++) {
                    var dot = document.getElementById('dot-' + i);
                    if (dot) {
                        dot.style.background = i === index
                            ? '#ffffff'
                            : 'rgba(255,255,255,0.3)';
                    }
                }
            };

            // Auto-advance slider
            setInterval(function () {
                var next = (currentSlide + 1) % totalSlides;
                window.moveSlider(next);
            }, 5000);
        });
    </script>

</body>
</html>