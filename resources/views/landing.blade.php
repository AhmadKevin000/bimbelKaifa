<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KAIFA Tutoring Center | Teman Belajar</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
<<<<<<< Updated upstream
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-nunito { font-family: 'Nunito Sans', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased overflow-x-hidden">

    <nav class="fixed w-full bg-white/90 backdrop-blur-md shadow-sm z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('images/Kaifa.png') }}" alt="Logo Kaifa" class="h-10 md:h-12 w-auto object-contain">
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-sky-600 font-medium transition">Beranda</a>
                    <a href="#program" class="text-gray-500 hover:text-sky-600 font-medium transition">Program</a>
                    <a href="#keunggulan" class="text-gray-500 hover:text-sky-600 font-medium transition">Keunggulan</a>
                    <a href="#testimoni" class="text-gray-500 hover:text-sky-600 font-medium transition">Testimoni</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    <a href="/admin/login" class="text-gray-600 font-medium hover:text-sky-600 px-4 py-2 border border-gray-200 rounded-full transition">Login</a>
                    <a href="#" class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-2 rounded-full font-medium transition shadow-md shadow-sky-200">
                        Sign Up
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 hover:text-sky-600 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
=======

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&family=Nunito+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --kaifa-surface: #f7f9fb;
            --kaifa-surface-low: #f2f4f6;
            --kaifa-primary: #1a146b;
            --kaifa-primary-container: #312e81;
            --kaifa-secondary: #006591;
            --kaifa-secondary-soft: #c9e6ff;
            --kaifa-muted: #64748b;
            --kaifa-cta-start: #f59e0b;
            --kaifa-cta-end: #f97316;
        }

        body {
            overflow-x: hidden;
            background: var(--kaifa-surface);
            color: #191c1e;
            font-family: 'Nunito Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .font-display {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(16px);
        }

        .cta-button {
            background: linear-gradient(135deg, var(--kaifa-cta-start) 0%, var(--kaifa-cta-end) 100%);
            box-shadow: 0 14px 30px -16px rgba(245, 158, 11, 0.75);
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .cta-button:hover {
            box-shadow: 0 20px 36px -18px rgba(249, 115, 22, 0.85);
            transform: translateY(-2px);
        }

        .feature-card {
            box-shadow: 0 4px 20px -2px rgba(49, 46, 129, 0.05);
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .feature-card:hover {
            box-shadow: 0 20px 40px -10px rgba(49, 46, 129, 0.12);
            transform: translateY(-4px);
        }

        .fade-up {
            animation: fadeUp 700ms ease-out both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="antialiased">
    <nav class="fixed top-0 z-50 w-full border-b border-white/50 bg-white/75 shadow-sm backdrop-blur-xl">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-5 md:px-16">
            <a href="#hero" class="flex items-center gap-3">
                <img src="{{ asset('images/Kaifa.png') }}" alt="Logo KAIFA" class="h-11 w-auto object-contain">
            </a>

            <div class="hidden items-center gap-8 font-display text-sm font-semibold md:flex">
                <a href="#program" class="text-slate-600 transition hover:text-[#1a146b]">Program</a>
                <a href="#tentang" class="text-slate-600 transition hover:text-[#1a146b]">Alumni</a>
                <a href="#faq" class="text-slate-600 transition hover:text-[#1a146b]">FAQ</a>
                <a href="#testimoni" class="text-slate-600 transition hover:text-[#1a146b]">Testimoni</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="https://wa.me/6285232169460" class="cta-button hidden rounded-full px-5 py-3 font-display text-sm font-bold text-white sm:inline-flex">
                    Daftar Sekarang
                </a>
                <button id="mobile-menu-button" type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-[#1a146b] md:hidden" aria-label="Buka menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white/95 px-5 py-4 md:hidden">
            <div class="flex flex-col gap-4 font-display text-sm font-semibold">
                <a href="#program" class="text-slate-700">Program</a>
                <a href="#tentang" class="text-slate-700">Alumni</a>
                <a href="#faq" class="text-slate-700">FAQ</a>
                <a href="#testimoni" class="text-slate-700">Testimoni</a>
                <a href="https://wa.me/6285232169460" class="cta-button inline-flex w-max rounded-full px-5 py-3 text-white">Daftar Sekarang</a>
>>>>>>> Stashed changes
            </div>
        </div>
    </nav>

<<<<<<< Updated upstream
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-40 overflow-hidden bg-sky-50 rounded-b-[3rem] lg:rounded-b-[10rem]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        <span class="text-amber-500">Belajar Lebih Mudah</span><br />
                        <span class="text-indigo-900">Bersama Kaifa</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Kaifa hadir sebagai teman belajar terpercaya untuk anak-anak dari usia dini hingga persiapan ujian masuk perguruan tinggi.
                    </p>
                    <div class="flex justify-center lg:justify-start">
                        <a href="#program" class="bg-sky-800 hover:bg-sky-900 text-white px-8 py-4 rounded-full font-semibold text-lg transition shadow-xl">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
                <div class="relative mx-auto w-full max-w-md lg:max-w-none mt-12 lg:mt-0">
                    <img src="{{ asset('images/hero-siswa.png') }}" alt="Hero Siswa" class="relative z-10 mx-auto w-[80%] rounded-3xl object-cover">
                    
                    <div class="absolute top-10 left-0 bg-white/90 backdrop-blur p-3 rounded-2xl shadow-xl flex items-center gap-3 z-20 animate-bounce">
                        <div class="bg-sky-100 p-2 rounded-full text-sky-600 text-xl">🎓</div>
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-gray-900">80+</p>
                            <p class="text-xs text-gray-500">Siswa Aktif</p>
                        </div>
                    </div>
                    <div class="absolute bottom-20 right-0 bg-white/90 backdrop-blur p-3 rounded-2xl shadow-xl flex items-center gap-3 z-20 animate-bounce">
                        <div class="bg-sky-100 p-2 rounded-full text-sky-600 text-xl">🎓</div>
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-gray-900">Sistem Terpadu</p>
                            <p class="text-xs text-gray-500">Gabung Kelas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-20">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-indigo-950 mb-4">Keberhasilan Kami</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Kami terus berkomitmen menghadirkan pendidikan berkualitas dan telah dipercaya oleh ratusan keluarga.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-5xl font-light text-sky-600 mb-2 font-nunito">80+</div>
                <div class="text-gray-600 font-medium">Siswa Aktif</div>
            </div>
            <div>
                <div class="text-5xl font-light text-sky-600 mb-2 font-nunito">3</div>
                <div class="text-gray-600 font-medium">Program Unggulan</div>
            </div>
            <div>
                <div class="text-5xl font-light text-sky-600 mb-2 font-nunito">15+</div>
                <div class="text-gray-600 font-medium">Pengajar Ahli</div>
            </div>
            <div>
                <div class="text-5xl font-light text-sky-600 mb-2 font-nunito">±5</div>
                <div class="text-gray-600 font-medium">Tahun Berdiri</div>
            </div>
        </div>
    </section>

    <section id="program" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-indigo-900 mb-4">Program Kami</h2>
                <p class="text-gray-500 max-w-3xl mx-auto text-lg">Kami menyediakan program belajar yang terstruktur dan menyenangkan untuk semua jenjang, mulai dari usia dini hingga persiapan ujian.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-[2rem] p-8 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] text-center border border-gray-50 hover:-translate-y-2 transition-transform">
                    <div class="w-20 h-20 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-200">
                        <span class="text-3xl text-white">👧</span>
                    </div>
                    <h3 class="text-2xl font-bold text-indigo-900 mb-4">Calistung AHe</h3>
                    <p class="text-gray-500">Program membaca, menulis, dan berhitung untuk anak usia dini agar siap memasuki jenjang sekolah dasar.</p>
                </div>
                <div class="bg-white rounded-[2rem] p-8 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] text-center border border-gray-50 hover:-translate-y-2 transition-transform">
                    <div class="w-20 h-20 bg-teal-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-200">
                        <span class="text-3xl text-white">📚</span>
                    </div>
                    <h3 class="text-2xl font-bold text-indigo-900 mb-4">Reguler Kelas 1–12</h3>
                    <p class="text-gray-500">Bimbingan belajar semua mata pelajaran untuk siswa SD, SMP, hingga SMA sesuai kurikulum nasional.</p>
                </div>
                <div class="bg-white rounded-[2rem] p-8 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] text-center border border-gray-50 hover:-translate-y-2 transition-transform">
                    <div class="w-20 h-20 bg-sky-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-sky-200">
                        <span class="text-3xl text-white">🎓</span>
                    </div>
                    <h3 class="text-2xl font-bold text-indigo-900 mb-4">TKA</h3>
                    <p class="text-gray-500">Persiapan intensif Tes Kemampuan Akademik untuk seleksi masuk perguruan tinggi negeri favorit.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-indigo-900 mb-6">Akses Sistem Terpadu Kaifa</h2>
                <p class="text-lg text-gray-500 max-w-4xl mx-auto">
                    Sistem manajemen informasi kami dirancang untuk memudahkan pengajar dalam mengelola sesi kelas, sekaligus membantu siswa dan orang tua memantau jadwal serta perkembangan belajar secara transparan.
                </p>
            </div>
            
            <div class="relative max-w-4xl mx-auto rounded-3xl overflow-hidden shadow-2xl group cursor-pointer">
                <img src="{{ asset('images/dashboard-portal.png') }}" alt="Dashboard" class="w-full object-cover transition-transform duration-500 group-hover:scale-105">
                
                <div class="absolute inset-0 bg-indigo-900/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="text-center transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500 ease-out">
                        <p class="text-white text-2xl md:text-3xl font-semibold mb-6">PORTAL SISWA</p>
                        <a href="#" class="bg-cyan-400 hover:bg-cyan-500 text-white px-8 py-3 rounded-full font-medium text-lg transition shadow-lg shadow-cyan-500/30">
                            Mulai Belajar
                        </a>
                    </div>
                </div>
=======
    <main class="pt-20">
        <section id="hero" class="relative flex min-h-[calc(100vh-80px)] items-center overflow-hidden px-5 py-20 md:px-16 lg:py-28">
            <div class="absolute right-[-12%] top-0 -z-10 h-full w-2/3 rounded-full bg-[#c9e6ff]/50 blur-[120px]"></div>
            <div class="absolute left-[-20%] top-20 -z-10 h-72 w-72 rounded-full bg-orange-100/70 blur-[90px]"></div>

            <div class="mx-auto grid w-full max-w-7xl items-center gap-12 lg:grid-cols-2">
                <div class="fade-up">
                    <span class="mb-6 inline-flex items-center rounded-full bg-[#c9e6ff] px-4 py-2 font-display text-sm font-semibold text-[#004c6e] shadow-sm">
                        <span class="material-symbols-outlined mr-2 text-base" style="font-variation-settings: 'FILL' 1;">star</span>
                        Dipercaya oleh 80+ siswa di Malang
                    </span>
                    <h1 class="font-display text-4xl font-extrabold leading-tight text-[#1a146b] md:text-5xl lg:text-6xl">
                        Raih Kampus Impian Bersama <span class="text-[#006591]">KAIFA Tutoring Center</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-600">
                        Bimbingan belajar intensif dengan kurikulum terpersonalisasi untuk membantumu menaklukkan ujian masuk PTN dan sekolah kedinasan.
                    </p>
                    <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                        <a href="https://wa.me/6285232169460" class="cta-button inline-flex items-center justify-center rounded-full px-8 py-4 font-display font-bold text-white">
                            Mulai Belajar Sekarang
                            <span class="material-symbols-outlined ml-2 text-xl">arrow_forward</span>
                        </a>
                        <a href="#program" class="inline-flex items-center justify-center rounded-full border-2 border-[#1a146b] px-8 py-4 font-display font-bold text-[#1a146b] transition hover:bg-[#1a146b]/5">
                            Lihat Program
                        </a>
                    </div>
                </div>

                <div class="fade-up relative mx-auto w-full max-w-[560px]" style="animation-delay: 120ms;">
                    <div class="overflow-hidden rounded-3xl bg-[#006591] shadow-2xl rotate-2 transition duration-500 hover:rotate-0">
                        <img src="{{ asset('images/hero-siswa.png') }}" alt="Siswa KAIFA" class="h-[420px] w-full object-cover md:h-[520px]">
                    </div>
                    <div class="glass-card absolute -bottom-6 -left-2 max-w-[260px] rounded-2xl p-5 shadow-xl md:-left-8">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-amber-500 text-white">
                                <span class="material-symbols-outlined">trending_up</span>
                            </div>
                            <div>
                                <p class="font-display font-extrabold text-[#1a146b]">95% Kelulusan</p>
                                <p class="text-xs leading-5 text-slate-500">Siswa diterima di PTN Favorit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="bg-white px-5 py-20 md:px-16 lg:py-28">
            <div class="mx-auto grid max-w-7xl items-center gap-12 lg:grid-cols-2">
                <div class="overflow-hidden rounded-3xl bg-[#006591] shadow-2xl rotate-2 transition duration-500 hover:rotate-0">
                    <img src="{{ asset('images/keunggulan1.png') }}" alt="Kegiatan belajar KAIFA" class="h-[360px] w-full object-cover md:h-[500px]">
                </div>

                <div>
                    <h2 class="font-display text-3xl font-extrabold text-[#1a146b] md:text-5xl">Tentang KAIFA</h2>
                    <p class="mt-6 text-lg leading-8 text-slate-600">
                        KAIFA (Karya Inspirasi Family) adalah pusat bimbingan belajar yang lahir dari semangat untuk memberikan pendidikan berkualitas yang personal dan menyenangkan. Kami percaya bahwa setiap anak memiliki potensi unik yang perlu diasah dengan metode yang tepat.
                    </p>

                    <div class="mt-10 grid gap-5 sm:grid-cols-2">
                        <div class="feature-card rounded-3xl border border-slate-100 bg-white p-6">
                            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#c9e6ff] text-[#006591]">
                                <span class="material-symbols-outlined">visibility</span>
                            </div>
                            <h3 class="font-display text-lg font-extrabold text-[#1a146b]">Visi Kami</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Menjadi pusat keunggulan akademik yang mencetak generasi cerdas, berkarakter, dan siap bersaing di tingkat global.</p>
                        </div>
                        <div class="feature-card rounded-3xl border border-slate-100 bg-white p-6">
                            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-2xl bg-[#c9e6ff] text-[#006591]">
                                <span class="material-symbols-outlined">flag</span>
                            </div>
                            <h3 class="font-display text-lg font-extrabold text-[#1a146b]">Misi Kami</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Mendampingi setiap siswa mencapai prestasi terbaiknya melalui pendekatan humanis dan kurikulum adaptif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="px-5 py-20 md:px-16 lg:py-28">
            <div class="mx-auto max-w-7xl">
                <div class="mx-auto mb-14 max-w-2xl text-center">
                    <h2 class="font-display text-3xl font-extrabold text-[#1a146b] md:text-5xl">Program Unggulan Kami</h2>
                    <p class="mt-4 text-lg leading-8 text-slate-600">Pilih program yang paling sesuai dengan tahap belajar dan target akademik siswa.</p>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <article class="feature-card flex flex-col rounded-3xl border border-slate-200 bg-white p-8">
                        <div class="mb-7">
                            <h3 class="font-display text-2xl font-extrabold text-[#1a146b]">Mandiri</h3>
                            <p class="mt-2 text-sm text-slate-500">Fokus pada pendalaman materi dasar</p>
                        </div>
                        <ul class="mb-10 flex-grow space-y-4">
                            <li class="flex gap-3 text-slate-700"><span class="material-symbols-outlined text-[#006591]">check_circle</span>3x Pertemuan / Minggu</li>
                            <li class="flex gap-3 text-slate-700"><span class="material-symbols-outlined text-[#006591]">check_circle</span>Modul Pembelajaran Lengkap</li>
                            <li class="flex gap-3 text-slate-700"><span class="material-symbols-outlined text-[#006591]">check_circle</span>Try Out Bulanan</li>
                        </ul>
                        <a href="https://wa.me/6285232169460" class="rounded-xl border-2 border-[#006591] px-5 py-4 text-center font-display font-bold text-[#006591] transition hover:bg-[#006591] hover:text-white">Detail Program</a>
                    </article>

                    <article class="relative flex scale-[1.02] flex-col rounded-3xl bg-[#1a146b] p-8 shadow-2xl md:scale-105">
                        <span class="absolute -top-4 left-1/2 -translate-x-1/2 rounded-full bg-amber-500 px-4 py-1 font-display text-xs font-extrabold uppercase tracking-widest text-white">Terpopuler</span>
                        <div class="mb-7">
                            <h3 class="font-display text-2xl font-extrabold text-white">Reguler</h3>
                            <p class="mt-2 text-sm text-[#c3c0ff]">Persiapan UTBK & Ujian Mandiri PTN</p>
                        </div>
                        <ul class="mb-10 flex-grow space-y-4">
                            <li class="flex gap-3 text-white"><span class="material-symbols-outlined text-[#39b8fd]">check_circle</span>5x Pertemuan / Minggu</li>
                            <li class="flex gap-3 text-white"><span class="material-symbols-outlined text-[#39b8fd]">check_circle</span>Konsultasi Jurusan Private</li>
                            <li class="flex gap-3 text-white"><span class="material-symbols-outlined text-[#39b8fd]">check_circle</span>Try Out Mingguan</li>
                            <li class="flex gap-3 text-white"><span class="material-symbols-outlined text-[#39b8fd]">check_circle</span>Bank Soal Eksklusif</li>
                        </ul>
                        <a href="https://wa.me/6285232169460" class="cta-button rounded-xl px-5 py-4 text-center font-display font-extrabold text-white">Daftar Sekarang</a>
                    </article>

                    <article class="feature-card flex flex-col rounded-3xl border border-slate-200 bg-white p-8">
                        <div class="mb-7">
                            <h3 class="font-display text-2xl font-extrabold text-[#1a146b]">Kedinasan</h3>
                            <p class="mt-2 text-sm text-slate-500">Fokus STAN, STIS, IPDN & Poltek</p>
                        </div>
                        <ul class="mb-10 flex-grow space-y-4">
                            <li class="flex gap-3 text-slate-700"><span class="material-symbols-outlined text-[#006591]">check_circle</span>Materi SKD & Psikotes</li>
                            <li class="flex gap-3 text-slate-700"><span class="material-symbols-outlined text-[#006591]">check_circle</span>Latihan Fisik & Wawancara</li>
                            <li class="flex gap-3 text-slate-700"><span class="material-symbols-outlined text-[#006591]">check_circle</span>Super Intensif (Setiap Hari)</li>
                        </ul>
                        <a href="https://wa.me/6285232169460" class="rounded-xl border-2 border-[#006591] px-5 py-4 text-center font-display font-bold text-[#006591] transition hover:bg-[#006591] hover:text-white">Detail Program</a>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-[#f2f4f6] px-5 py-20 md:px-16 lg:py-28">
            <div class="mx-auto grid max-w-7xl items-center gap-14 lg:grid-cols-2">
                <div>
                    <h2 class="font-display text-3xl font-extrabold text-[#1a146b] md:text-5xl">Fasilitas Belajar Premium</h2>
                    <p class="mt-5 max-w-xl text-lg leading-8 text-slate-600">Kami percaya lingkungan yang nyaman dan teknologi yang tepat adalah kunci efektivitas belajar.</p>

                    <div class="mt-12 grid gap-7 sm:grid-cols-2">
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-[#006591] shadow-md"><span class="material-symbols-outlined text-3xl">computer</span></div>
                            <div>
                                <h3 class="font-display font-extrabold text-[#1a146b]">CBT System</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Simulasi ujian berbasis komputer seperti UTBK asli.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-[#006591] shadow-md"><span class="material-symbols-outlined text-3xl">ac_unit</span></div>
                            <div>
                                <h3 class="font-display font-extrabold text-[#1a146b]">AC Room</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Ruang kelas sejuk dan nyaman maksimal 10 siswa.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-[#006591] shadow-md"><span class="material-symbols-outlined text-3xl">person_celebrate</span></div>
                            <div>
                                <h3 class="font-display font-extrabold text-[#1a146b]">Tutor Expert</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Pengajar berpengalaman dari PTN ternama.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-[#006591] shadow-md"><span class="material-symbols-outlined text-3xl">library_books</span></div>
                            <div>
                                <h3 class="font-display font-extrabold text-[#1a146b]">Modul Update</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Materi disusun berdasarkan kisi-kisi terbaru.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="{{ asset('images/keunggulan2.png') }}" alt="Laporan belajar KAIFA" class="h-64 w-full rounded-3xl object-cover shadow-lg">
                        <img src="{{ asset('images/rapor_pdf_mockup.png') }}" alt="Contoh rapor perkembangan" class="h-48 w-full rounded-3xl bg-white object-contain p-4 shadow-lg">
                    </div>
                    <div class="space-y-4 pt-8">
                        <img src="{{ asset('images/keunggulan3.png') }}" alt="Kurikulum KAIFA" class="h-48 w-full rounded-3xl object-cover shadow-lg">
                        <img src="{{ asset('images/hero-siswa.png') }}" alt="Siswa KAIFA" class="h-64 w-full rounded-3xl bg-white object-contain p-4 shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="px-5 py-20 md:px-16 lg:py-28">
            <div class="mx-auto max-w-3xl">
                <div class="mb-12 text-center">
                    <h2 class="font-display text-3xl font-extrabold text-[#1a146b] md:text-4xl">Paling Sering Ditanyakan</h2>
                    <p class="mt-4 text-slate-600">Punya pertanyaan? Mungkin jawabannya ada di sini.</p>
                </div>

                <div class="space-y-4">
                    <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-6 font-display font-extrabold text-[#1a146b]">
                            Berapa biaya bimbingan di KAIFA?
                            <span class="material-symbols-outlined transition group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="border-t border-slate-100 p-6 pt-4 leading-7 text-slate-600">
                            Biaya bimbingan bervariasi tergantung program yang dipilih, mulai dari Rp 500.000/bulan. Tersedia pilihan pembayaran cicilan dan diskon khusus bagi siswa berprestasi.
                        </div>
                    </details>
                    <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-6 font-display font-extrabold text-[#1a146b]">
                            Apakah ada pembatasan jumlah siswa per kelas?
                            <span class="material-symbols-outlined transition group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="border-t border-slate-100 p-6 pt-4 leading-7 text-slate-600">
                            Ya, demi efektivitas belajar, kami membatasi maksimal 10 siswa per kelas untuk program Reguler dan Mandiri, serta maksimal 5 siswa untuk program VIP.
                        </div>
                    </details>
                    <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-6 font-display font-extrabold text-[#1a146b]">
                            Bagaimana jadwal belajar di KAIFA?
                            <span class="material-symbols-outlined transition group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="border-t border-slate-100 p-6 pt-4 leading-7 text-slate-600">
                            Kami menyediakan jadwal pagi, siang, dan sore (15.30 - 17.30). Siswa dapat memilih sesi yang paling tidak mengganggu kegiatan sekolah utama.
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <section id="testimoni" class="relative overflow-hidden bg-[#1a146b] px-5 py-20 md:px-16 lg:py-28">
            <span class="material-symbols-outlined pointer-events-none absolute left-8 top-8 text-[180px] text-white/5" style="font-variation-settings: 'FILL' 1;">format_quote</span>
            <div class="relative z-10 mx-auto max-w-7xl">
                <h2 class="mb-14 text-center font-display text-3xl font-extrabold text-white md:text-5xl">Apa Kata Mereka?</h2>

                <div class="mx-auto max-w-3xl overflow-hidden">
                    <div id="testimonial-track" class="flex transition-transform duration-500 ease-in-out">
                        <article class="w-full flex-shrink-0 px-2">
                            <div class="rounded-3xl border border-white/10 bg-white/10 p-8 text-center text-white backdrop-blur-md md:p-10">
                                <p class="mx-auto max-w-2xl text-lg italic leading-8 md:text-xl">"KAIFA membantu saya memahami konsep Matematika yang sulit dengan cara yang sangat sederhana. Berkat tutor di sini, saya berhasil lolos di Kedokteran UB!"</p>
                                <div class="mt-8 flex items-center justify-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-white bg-[#c9e6ff] font-display font-extrabold text-[#1a146b]">A</div>
                                    <div class="text-left">
                                        <p class="font-display font-extrabold text-white">Adinda Rahma</p>
                                        <p class="text-sm text-[#c3c0ff]">Alumni Kedokteran UB</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="w-full flex-shrink-0 px-2">
                            <div class="rounded-3xl border border-white/10 bg-white/10 p-8 text-center text-white backdrop-blur-md md:p-10">
                                <p class="mx-auto max-w-2xl text-lg italic leading-8 md:text-xl">"Fasilitas CBT-nya sangat membantu membiasakan diri dengan tekanan waktu saat ujian asli. Modulnya juga sangat update dengan soal-soal HOTS terbaru."</p>
                                <div class="mt-8 flex items-center justify-center gap-4">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-white bg-[#c9e6ff] font-display font-extrabold text-[#1a146b]">F</div>
                                    <div class="text-left">
                                        <p class="font-display font-extrabold text-white">Farel Prasetyo</p>
                                        <p class="text-sm text-[#c3c0ff]">Alumni STEI ITB</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="mt-8 flex justify-center gap-2">
                    <button type="button" class="testimonial-dot h-3 w-3 rounded-full bg-white transition" data-slide="0" aria-label="Testimoni 1"></button>
                    <button type="button" class="testimonial-dot h-3 w-3 rounded-full bg-white/30 transition" data-slide="1" aria-label="Testimoni 2"></button>
                </div>
            </div>
        </section>

        <section class="px-5 py-16 md:px-16 lg:py-24">
            <div class="relative mx-auto max-w-7xl overflow-hidden rounded-[32px] bg-gradient-to-r from-[#1a146b] to-[#006591] px-8 py-14 text-center shadow-2xl md:px-20 md:py-20">
                <div class="absolute inset-0 opacity-10">
                    <div class="grid h-full grid-cols-8">
                        @for ($i = 0; $i < 32; $i++)
                            <div class="border-b border-r border-white"></div>
                        @endfor
                    </div>
                </div>
                <div class="relative z-10">
                    <h2 class="font-display text-3xl font-extrabold text-white md:text-5xl">Siap Meraih Prestasi Impianmu?</h2>
                    <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-[#c9e6ff]">Konsultasikan kebutuhan belajarmu dengan tim ahli kami secara gratis via WhatsApp.</p>
                    <a href="https://wa.me/6285232169460" class="mt-9 inline-flex items-center justify-center gap-3 rounded-full bg-white px-8 py-4 font-display font-extrabold text-[#1a146b] shadow-xl transition hover:bg-[#c9e6ff]">
                        <svg class="h-6 w-6 fill-green-500" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.224-3.82c1.516.903 3.123 1.379 4.763 1.38h.005c5.333 0 9.674-4.34 9.677-9.674.002-2.586-1.003-5.015-2.83-6.841-1.827-1.827-4.255-2.831-6.842-2.831-5.334 0-9.675 4.341-9.677 9.675-.001 1.751.463 3.454 1.341 4.956l-.996 3.637 3.719-.976zm11.233-6.076c-.305-.152-1.805-.891-2.084-.993-.279-.101-.482-.152-.684.152-.203.304-.787.993-.965 1.194-.177.202-.355.228-.66.076-.304-.152-1.285-.474-2.447-1.511-.904-.806-1.514-1.802-1.691-2.105-.178-.304-.019-.468.133-.619.137-.136.305-.355.457-.533.151-.177.203-.304.304-.507.102-.202.051-.38-.025-.532-.076-.152-.684-1.648-.938-2.257-.247-.594-.499-.514-.684-.523-.177-.009-.38-.011-.583-.011s-.532.076-.811.38c-.279.304-1.065 1.039-1.065 2.535s1.09 2.94 1.242 3.143c.152.202 2.144 3.275 5.193 4.591.725.313 1.291.5 1.731.64.729.231 1.391.199 1.915.121.584-.087 1.805-.735 2.058-1.444.253-.709.253-1.317.177-1.444-.075-.127-.278-.203-.583-.355z"></path></svg>
                        Hubungi Admin Sekarang
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white px-5 py-16 md:px-16">
        <div class="mx-auto grid max-w-7xl gap-10 md:grid-cols-4">
            <div>
                <img src="{{ asset('images/Kaifa.png') }}" alt="Logo KAIFA" class="mb-6 h-14 w-auto object-contain">
                <p class="leading-7 text-slate-600">Partner terpercaya persiapan masa depan akademik siswa terbaik di Malang.</p>
                <div class="mt-6 flex gap-4 text-[#1a146b]">
                    <span class="material-symbols-outlined">photo_camera</span>
                    <span class="material-symbols-outlined">alternate_email</span>
                    <span class="material-symbols-outlined">call</span>
                </div>
            </div>

            <div>
                <h3 class="mb-6 font-display font-extrabold text-[#1a146b]">Quick Links</h3>
                <ul class="space-y-4 text-slate-600">
                    <li><a href="#tentang" class="transition hover:text-[#006591]">Tentang Kami</a></li>
                    <li><a href="#program" class="transition hover:text-[#006591]">Program Unggulan</a></li>
                    <li><a href="#faq" class="transition hover:text-[#006591]">Bantuan</a></li>
                    <li><a href="#" class="transition hover:text-[#006591]">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-6 font-display font-extrabold text-[#1a146b]">Kontak & Alamat</h3>
                <div class="space-y-4 text-slate-600">
                    <p class="flex gap-3"><span class="material-symbols-outlined text-[#006591]">location_on</span>Perumahan Sulfat Indah, Malang, Jawa Timur</p>
                    <p class="flex gap-3"><span class="material-symbols-outlined text-[#006591]">call</span>+62 812-3456-7890</p>
                    <p class="flex gap-3"><span class="material-symbols-outlined text-[#006591]">mail</span>info@kaifa.edu</p>
                </div>
            </div>

            <div>
                <h3 class="mb-6 font-display font-extrabold text-[#1a146b]">Jam Operasional</h3>
                <div class="space-y-2 text-slate-600">
                    <p class="font-extrabold text-slate-800">Senin - Sabtu</p>
                    <p>08.00 - 18.00 WIB</p>
                    <p class="pt-4 font-extrabold text-slate-800">Minggu</p>
                    <p>Tutup (Hanya kelas VIP)</p>
                </div>
            </div>
        </div>

        <div class="mx-auto mt-14 max-w-7xl border-t border-slate-200 pt-8 text-center text-sm text-slate-500">
            &copy; 2026 KAIFA Tutoring Center. All rights reserved.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const track = document.getElementById('testimonial-track');
            const dots = document.querySelectorAll('.testimonial-dot');
            let currentSlide = 0;

            mobileButton?.addEventListener('click', () => {
                mobileMenu?.classList.toggle('hidden');
            });

            mobileMenu?.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
            });

            function moveSlider(index) {
                currentSlide = index;
                track.style.transform = `translateX(-${index * 100}%)`;

                dots.forEach((dot, dotIndex) => {
                    dot.classList.toggle('bg-white', dotIndex === index);
                    dot.classList.toggle('bg-white/30', dotIndex !== index);
                });
            }

            dots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    moveSlider(Number(dot.dataset.slide));
                });
            });

            setInterval(() => {
                moveSlider((currentSlide + 1) % dots.length);
            }, 5000);
        });
    </script>
</body>
</html>
