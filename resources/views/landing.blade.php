<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KAIFA Tutoring Center | Bimbel Terbaik di Malang</title>

    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito+Sans:wght@300;400;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />


</head>

<body class="bg-surface font-body-md text-on-surface">
    <!-- Top Navigation Bar -->
    <nav
        class="fixed top-0 w-full z-50 bg-surface-white/70 backdrop-blur-md border-b border-surface-white/20 shadow-sm">
        <div
            class="flex justify-between items-center h-20 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
            <a href="#hero" class="flex items-center gap-3">
                <img src="{{ asset($photos['logo']) }}" alt="Logo KAIFA" class="h-11 w-auto object-contain">
            </a>
            <div class="hidden md:flex items-center space-x-8 font-label-md text-label-md">
                <a class="text-on-surface-variant hover:text-primary transition-colors hover:scale-105"
                    href="#tentang">Tentang Kami</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors hover:scale-105"
                    href="#program">Program</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors hover:scale-105"
                    href="#fasilitas">Fasilitas</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors hover:scale-105"
                    href="#faq">FAQ</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors hover:scale-105"
                    href="#testimoni">Testimoni</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="https://wa.link/bmd9s5" target="_blank"
                    class="cta-button px-6 py-3 rounded-full text-white font-label-md text-label-md active:scale-95 inline-block text-center shadow-md">
                    Daftar Sekarang
                </a>
                <button id="mobile-menu-button" type="button"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-primary md:hidden"
                    aria-label="Buka menu">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white/95 px-5 py-4 md:hidden">
            <div class="flex flex-col gap-4 font-display-lg text-sm font-semibold">
                <a href="#tentang" class="text-slate-700">Tentang Kami</a>
                <a href="#program" class="text-slate-700">Program</a>
                <a href="#fasilitas" class="text-slate-700">Fasilitas</a>
                <a href="#faq" class="text-slate-700">FAQ</a>
                <a href="#testimoni" class="text-slate-700">Testimoni</a>
            </div>
        </div>
    </nav>

    <main class="pt-20">
        <!-- Hero Section -->
        <section id="hero"
            class="relative min-h-[calc(100vh-80px)] flex items-center overflow-hidden px-margin-mobile md:px-margin-desktop py-section-gap">
            <div
                class="absolute top-0 right-0 w-1/2 h-full bg-secondary-fixed/20 blur-[120px] rounded-full -z-10 translate-x-1/4">
            </div>
            <div class="absolute left-[-20%] top-20 -z-10 h-72 w-72 rounded-full bg-orange-100/70 blur-[90px]"></div>

            <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-gutter items-center">
                <div class="animate-fade-up">
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant font-label-md text-sm mb-6 shadow-sm">
                        <span class="material-symbols-outlined text-sm mr-2"
                            style="font-variation-settings: 'FILL' 1;">star</span>
                        Dipercaya oleh 80+ Siswa di Malang
                    </span>
                    <h1
                        class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-6 leading-tight font-extrabold">
                        Raih Kampus Impian Bersama <span class="text-secondary">KAIFA Tutoring Center</span>
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-lg">
                        Bimbingan belajar intensif dengan kurikulum terpersonalisasi untuk membantumu menaklukkan ujian
                        masuk PTN dan sekolah kedinasan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="https://wa.link/bmd9s5" target="_blank"
                            class="cta-button px-8 py-4 rounded-full text-white font-bold flex items-center justify-center shadow-lg">
                            Mulai Belajar Sekarang
                            <span class="material-symbols-outlined ml-2">arrow_forward</span>
                        </a>
                        <a href="#program"
                            class="px-8 py-4 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary/5 transition-colors flex items-center justify-center">
                            Lihat Program
                        </a>
                    </div>
                </div>
                <div class="relative animate-fade-up" style="animation-delay: 0.2s;">
                    <div
                        class="rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img alt="Siswa KAIFA" class="w-full h-[420px] md:h-[500px] object-cover"
                            src="{{ asset($photos['hero']) }}" />
                    </div>
                    <!-- Floating Glass Card -->
                    <div class="absolute -bottom-6 -left-6 glass-card p-6 rounded-2xl shadow-xl max-w-xs animate-bounce"
                        style="animation-duration: 3s;">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-cta-gradient-start rounded-full flex items-center justify-center text-white">
                                <span class="material-symbols-outlined">trending_up</span>
                            </div>
                            <div>
                                <p class="font-bold text-primary">95% Kelulusan</p>
                                <p class="text-xs text-on-surface-variant">Siswa diterima di PTN Favorit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alumni Section -->
        <section class="py-section-gap bg-surface-container-lowest overflow-hidden" id="tentang">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div
                        class="animate-fade-up rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img alt="Kegiatan belajar KAIFA" class="w-full h-[360px] md:h-[500px] object-cover"
                            src="{{ asset($photos['about']) }}" />
                    </div>
                    <div class="animate-fade-up" style="animation-delay: 0.2s;">
                        <h2
                            class="font-display-lg text-headline-md md:text-display-lg text-primary mb-8 font-extrabold">
                            Tentang KAIFA</h2>
                        <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 leading-relaxed">
                            KAIFA (Karya Inspirasi Family) adalah pusat bimbingan belajar yang lahir dari semangat untuk
                            memberikan pendidikan berkualitas yang personal dan menyenangkan. Kami percaya bahwa setiap
                            anak memiliki potensi unik yang perlu diasah dengan metode yang tepat.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="p-6 bg-surface-white rounded-2xl border border-outline-variant shadow-sm">
                                <div
                                    class="w-10 h-10 bg-secondary-fixed rounded-xl flex items-center justify-center text-on-secondary-fixed-variant mb-4">
                                    <span class="material-symbols-outlined">visibility</span>
                                </div>
                                <h3 class="font-headline-sm text-primary mb-2 font-bold">Visi Kami</h3>
                                <p class="text-body-md text-on-surface-variant text-sm">Menjadi pusat keunggulan
                                    akademik yang mencetak generasi cerdas, berkarakter, dan siap bersaing di tingkat
                                    global.</p>
                            </div>
                            <div class="p-6 bg-surface-white rounded-2xl border border-outline-variant shadow-sm">
                                <div
                                    class="w-10 h-10 bg-secondary-fixed rounded-xl flex items-center justify-center text-on-secondary-fixed-variant mb-4">
                                    <span class="material-symbols-outlined">flag</span>
                                </div>
                                <h3 class="font-headline-sm text-primary mb-2 font-bold">Misi Kami</h3>
                                <p class="text-body-md text-on-surface-variant text-sm">Mendampingi setiap siswa
                                    mencapai prestasi terbaiknya melalui pendekatan humanis dan kurikulum adaptif.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Section -->
        <section class="py-section-gap px-margin-mobile md:px-margin-desktop" id="program">
            <div class="max-w-container-max mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-display-lg text-headline-md md:text-display-lg text-primary mb-4 font-extrabold">
                        Program Unggulan Kami</h2>
                    <p class="font-body-lg text-on-surface-variant max-w-2xl mx-auto">Pilih paket belajar yang paling
                        sesuai dengan kebutuhan dan target akademikmu.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Mandiri Program -->
                    <div class="flip-card" id="card-mandiri">
                        <div class="flip-card-inner">
                            <!-- Front -->
                            <div class="flip-card-front bg-surface-white p-8 border border-outline-variant shadow-sm flex flex-col h-full">
                                <div class="mb-6 mt-2">
                                    <h3 class="font-display-lg text-headline-sm text-primary mb-2 font-bold">Mandiri</h3>
                                    <p class="text-on-surface-variant text-sm">Fokus pada pendalaman materi dasar</p>
                                </div>
                                <ul class="space-y-4 mb-10 flex-grow">
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary text-xl">check_circle</span>
                                        <span class="text-on-surface">3x Pertemuan / Minggu</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary text-xl">check_circle</span>
                                        <span class="text-on-surface">Modul Pembelajaran Lengkap</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary text-xl">check_circle</span>
                                        <span class="text-on-surface">Try Out Bulanan</span>
                                    </li>
                                </ul>
                                <button class="flip-trigger w-full py-4 rounded-xl border-2 border-secondary text-secondary font-bold hover:bg-secondary hover:text-white transition-colors text-center">Detail Program</button>
                            </div>
                            <!-- Back -->
                            <div class="flip-card-back bg-surface-container-high p-8 border border-outline-variant shadow-sm flex flex-col justify-center items-center text-center h-full">
                                <h3 class="font-display-lg text-headline-sm text-primary mb-6">Investasi Pendidikan</h3>
                                <div class="space-y-4 mb-10 w-full">
                                    <div class="p-4 bg-white rounded-xl shadow-sm border border-outline-variant/30 w-full">
                                        <p class="text-sm text-on-surface-variant uppercase tracking-wider font-bold mb-1">Pendaftaran</p>
                                        <p class="text-2xl font-bold text-primary">Rp 150.000</p>
                                    </div>
                                    <div class="p-4 bg-white rounded-xl shadow-sm border border-outline-variant/30 w-full">
                                        <p class="text-sm text-on-surface-variant uppercase tracking-wider font-bold mb-1">SPP Bulanan</p>
                                        <p class="text-2xl font-bold text-secondary">Rp 300.000</p>
                                    </div>
                                </div>
                                <div class="flex gap-3 w-full justify-center">
                                    <button class="flip-back-trigger px-6 py-3 rounded-full border border-outline-variant bg-white text-primary font-bold hover:bg-surface-container transition-colors">Kembali</button>
                                    <a href="https://wa.link/bmd9s5" target="_blank"
                                        class="cta-button px-6 py-3 rounded-full text-white font-bold text-center shadow-md">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reguler Program (Featured) -->
                    <div class="flip-card" id="card-reguler">
                        <div class="flip-card-inner">
                            <!-- Front -->
                            <div class="flip-card-front bg-primary p-8 shadow-xl flex flex-col h-full relative">
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-cta-gradient-start px-4 py-1 rounded-full text-white text-xs font-bold tracking-widest uppercase z-10">
                                    Terpopuler
                                </div>
                                <div class="mb-6 mt-2">
                                    <h3 class="font-display-lg text-headline-sm text-white mb-2 font-bold">Reguler</h3>
                                    <p class="text-primary-fixed-dim text-sm">Persiapan UTBK &amp; Ujian Mandiri PTN</p>
                                </div>
                                <ul class="space-y-4 mb-10 flex-grow">
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary-container text-xl">check_circle</span>
                                        <span class="text-white">5x Pertemuan / Minggu</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary-container text-xl">check_circle</span>
                                        <span class="text-white">Konsultasi Jurusan Private</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary-container text-xl">check_circle</span>
                                        <span class="text-white">Try Out Mingguan</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary-container text-xl">check_circle</span>
                                        <span class="text-white">Bank Soal Eksklusif</span>
                                    </li>
                                </ul>
                                <button class="flip-trigger w-full py-4 rounded-xl bg-white text-primary font-bold text-center shadow-lg hover:bg-opacity-90 transition-colors">Detail Program</button>
                            </div>
                            <!-- Back -->
                            <div class="flip-card-back bg-surface-container-high p-8 border border-outline-variant shadow-sm flex flex-col justify-center items-center text-center h-full">
                                <h3 class="font-display-lg text-headline-sm text-primary mb-6">Investasi Pendidikan</h3>
                                <div class="space-y-4 mb-10 w-full">
                                    <div class="p-4 bg-white rounded-xl shadow-sm border border-outline-variant/30 w-full">
                                        <p class="text-sm text-on-surface-variant uppercase tracking-wider font-bold mb-1">Pendaftaran</p>
                                        <p class="text-2xl font-bold text-primary">Rp 200.000</p>
                                    </div>
                                    <div class="p-4 bg-white rounded-xl shadow-sm border border-outline-variant/30 w-full">
                                        <p class="text-sm text-on-surface-variant uppercase tracking-wider font-bold mb-1">SPP Bulanan</p>
                                        <p class="text-2xl font-bold text-secondary">Rp 500.000</p>
                                    </div>
                                </div>
                                <div class="flex gap-3 w-full justify-center">
                                    <button class="flip-back-trigger px-6 py-3 rounded-full border border-outline-variant bg-white text-primary font-bold hover:bg-surface-container transition-colors">Kembali</button>
                                    <a href="https://wa.link/bmd9s5" target="_blank"
                                        class="cta-button px-6 py-3 rounded-full text-white font-bold text-center shadow-md">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Intensive Program -->
                    <div class="flip-card" id="card-kedinasan">
                        <div class="flip-card-inner">
                            <!-- Front -->
                            <div class="flip-card-front bg-surface-white p-8 border border-outline-variant shadow-sm flex flex-col h-full">
                                <div class="mb-6 mt-2">
                                    <h3 class="font-display-lg text-headline-sm text-primary mb-2 font-bold">Kedinasan</h3>
                                    <p class="text-on-surface-variant text-sm">Fokus STAN, STIS, IPDN &amp; Poltek</p>
                                </div>
                                <ul class="space-y-4 mb-10 flex-grow">
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary text-xl">check_circle</span>
                                        <span class="text-on-surface">Materi SKD &amp; Psikotes</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary text-xl">check_circle</span>
                                        <span class="text-on-surface">Latihan Fisik &amp; Wawancara</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary text-xl">check_circle</span>
                                        <span class="text-on-surface">Super Intensif (Setiap Hari)</span>
                                    </li>
                                </ul>
                                <button class="flip-trigger w-full py-4 rounded-xl border-2 border-secondary text-secondary font-bold hover:bg-secondary hover:text-white transition-colors text-center">Detail Program</button>
                            </div>
                            <!-- Back -->
                            <div class="flip-card-back bg-surface-container-high p-8 border border-outline-variant shadow-sm flex flex-col justify-center items-center text-center h-full">
                                <h3 class="font-display-lg text-headline-sm text-primary mb-6">Investasi Pendidikan</h3>
                                <div class="space-y-4 mb-10 w-full">
                                    <div class="p-4 bg-white rounded-xl shadow-sm border border-outline-variant/30 w-full">
                                        <p class="text-sm text-on-surface-variant uppercase tracking-wider font-bold mb-1">Pendaftaran</p>
                                        <p class="text-2xl font-bold text-primary">Rp 250.000</p>
                                    </div>
                                    <div class="p-4 bg-white rounded-xl shadow-sm border border-outline-variant/30 w-full">
                                        <p class="text-sm text-on-surface-variant uppercase tracking-wider font-bold mb-1">SPP Bulanan</p>
                                        <p class="text-2xl font-bold text-secondary">Rp 850.000</p>
                                    </div>
                                </div>
                                <div class="flex gap-3 w-full justify-center">
                                    <button class="flip-back-trigger px-6 py-3 rounded-full border border-outline-variant bg-white text-primary font-bold hover:bg-surface-container transition-colors">Kembali</button>
                                    <a href="https://wa.link/bmd9s5" target="_blank"
                                        class="cta-button px-6 py-3 rounded-full text-white font-bold text-center shadow-md">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facilities Section -->
        <section id="fasilitas" class="py-section-gap bg-surface-container-low px-margin-mobile md:px-margin-desktop">
            <div class="max-w-container-max mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-section-gap items-center">
                    <div>
                        <h2
                            class="font-display-lg text-headline-md md:text-display-lg text-primary mb-8 font-extrabold">
                            Fasilitas Belajar Premium</h2>
                        <p class="font-body-lg text-on-surface-variant mb-12">Kami percaya lingkungan yang nyaman dan
                            teknologi yang tepat adalah kunci efektivitas belajar.</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div class="flex gap-4">
                                <div
                                    class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center flex-shrink-0 text-secondary">
                                    <span class="material-symbols-outlined text-3xl">computer</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">CBT System</h4>
                                    <p class="text-sm text-on-surface-variant">Simulasi ujian berbasis komputer seperti
                                        UTBK asli.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center flex-shrink-0 text-secondary">
                                    <span class="material-symbols-outlined text-3xl">ac_unit</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">AC Room</h4>
                                    <p class="text-sm text-on-surface-variant">Ruang kelas sejuk dan nyaman maksimal 10
                                        siswa.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center flex-shrink-0 text-secondary">
                                    <span class="material-symbols-outlined text-3xl">person_celebrate</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">Tutor Expert</h4>
                                    <p class="text-sm text-on-surface-variant">Pengajar berpengalaman dari PTN ternama.
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div
                                    class="w-14 h-14 bg-white rounded-2xl shadow-md flex items-center justify-center flex-shrink-0 text-secondary">
                                    <span class="material-symbols-outlined text-3xl">library_books</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">Modul Update</h4>
                                    <p class="text-sm text-on-surface-variant">Materi disusun berdasarkan kisi-kisi
                                        terbaru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <img class="rounded-3xl h-64 w-full object-cover shadow-lg"
                                src="{{ asset($photos['facility_1']) }}" alt="Library KAIFA" />
                            <img class="rounded-3xl h-48 w-full object-cover shadow-lg p-2 bg-white"
                                src="{{ asset($photos['facility_2']) }}" alt="Rapor KAIFA" />
                        </div>
                        <div class="space-y-4 pt-8">
                            <img class="rounded-3xl h-48 w-full object-cover shadow-lg"
                                src="{{ asset($photos['facility_3']) }}" alt="Tutor Guidance" />
                            <img class="rounded-3xl h-64 w-full object-cover shadow-lg"
                                src="{{ asset($photos['facility_4']) }}" alt="Student Lounge" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-section-gap px-margin-mobile md:px-margin-desktop" id="faq">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="font-display-lg text-headline-md text-primary mb-4 font-extrabold">Paling Sering
                        Ditanyakan</h2>
                    <p class="text-on-surface-variant">Punya pertanyaan? Mungkin jawabannya ada di sini.</p>
                </div>
                <div class="space-y-4">
                    <details
                        class="group bg-surface-white rounded-2xl border border-outline-variant overflow-hidden transition-all duration-300">
                        <summary
                            class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-primary select-none">
                            Berapa rincian biaya bimbingan di KAIFA?
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div
                            class="p-6 pt-0 text-on-surface-variant border-t border-outline-variant/30 leading-relaxed">
                            Biaya bimbingan bervariasi tergantung program yang dipilih, mulai dari Rp 500.000/bulan.
                            Tersedia pilihan pembayaran cicilan dan diskon khusus bagi siswa berprestasi.
                        </div>
                    </details>
                    <details
                        class="group bg-surface-white rounded-2xl border border-outline-variant overflow-hidden transition-all duration-300">
                        <summary
                            class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-primary select-none">
                            Apakah ada pembatasan jumlah siswa per kelas?
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div
                            class="p-6 pt-0 text-on-surface-variant border-t border-outline-variant/30 leading-relaxed">
                            Ya, demi efektivitas belajar, kami membatasi maksimal 10 siswa per kelas untuk program
                            Reguler dan Mandiri, serta maksimal 5 siswa untuk program VIP.
                        </div>
                    </details>
                    <details
                        class="group bg-surface-white rounded-2xl border border-outline-variant overflow-hidden transition-all duration-300">
                        <summary
                            class="flex justify-between items-center p-6 cursor-pointer list-none font-bold text-primary select-none">
                            Bagaimana jadwal belajar di KAIFA?
                            <span
                                class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div
                            class="p-6 pt-0 text-on-surface-variant border-t border-outline-variant/30 leading-relaxed">
                            Kami menyediakan jadwal pagi, siang, dan sore (15.30 - 17.30). Siswa dapat memilih sesi yang
                            paling tidak mengganggu kegiatan sekolah utama.
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-section-gap bg-primary relative overflow-hidden px-margin-mobile md:px-margin-desktop"
            id="testimoni">
            <span
                class="material-symbols-outlined absolute top-10 left-10 text-[200px] text-white/5 pointer-events-none"
                style="font-variation-settings: 'FILL' 1;">format_quote</span>
            <div class="max-w-container-max mx-auto relative z-10">
                <h2
                    class="font-display-lg text-headline-md md:text-display-lg text-white text-center mb-16 font-extrabold">
                    Apa Kata Mereka?</h2>
                <div class="flex overflow-hidden relative" id="testimonial-slider">
                    <div class="flex transition-transform duration-500 ease-in-out w-full" id="slider-track"
                        style="transform: translateX(0%);">
                        <!-- Testimonial 1 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-white/10 backdrop-blur-md p-10 rounded-3xl border border-white/10 max-w-2xl mx-auto text-center">
                                <p class="text-white text-xl italic mb-8">"KAIFA membantu saya memahami konsep
                                    Matematika yang sulit dengan cara yang sangat sederhana. Berkat tutor di sini, saya
                                    berhasil lolos di Kedokteran UB!"</p>
                                <div class="flex items-center justify-center gap-4">
                                    <div
                                        class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-white bg-[#c9e6ff] font-display-lg font-extrabold text-[#1a146b]">
                                        A
                                    </div>
                                    <div class="text-left">
                                        <p class="text-white font-bold">Adinda Rahma</p>
                                        <p class="text-secondary-fixed-dim text-sm">Alumni Kedokteran UB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Testimonial 2 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div
                                class="bg-white/10 backdrop-blur-md p-10 rounded-3xl border border-white/10 max-w-2xl mx-auto text-center">
                                <p class="text-white text-xl italic mb-8">"Fasilitas CBT-nya sangat membantu membiasakan
                                    diri dengan tekanan waktu saat ujian asli. Modulnya juga sangat update dengan
                                    soal-soal HOTS terbaru."</p>
                                <div class="flex items-center justify-center gap-4">
                                    <div
                                        class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-white bg-[#c9e6ff] font-display-lg font-extrabold text-[#1a146b]">
                                        F
                                    </div>
                                    <div class="text-left">
                                        <p class="text-white font-bold">Farel Prasetyo</p>
                                        <p class="text-secondary-fixed-dim text-sm">Alumni STEI ITB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center gap-2 mt-8">
                    <button class="w-3 h-3 rounded-full transition-all bg-white" id="dot-0" onclick="moveSlider(0)"
                        aria-label="Testimonial 1"></button>
                    <button class="w-3 h-3 rounded-full transition-all bg-white/30" id="dot-1" onclick="moveSlider(1)"
                        aria-label="Testimonial 2"></button>
                </div>
            </div>
        </section>

        <!-- WhatsApp CTA -->
        <section class="py-20 px-margin-mobile md:px-margin-desktop">
            <div
                class="max-w-container-max mx-auto bg-gradient-to-r from-primary to-secondary rounded-[40px] p-10 md:p-20 text-center relative overflow-hidden shadow-xl">
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="grid grid-cols-10 h-full w-full">
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                        <div class="border-r border-b border-white"></div>
                    </div>
                </div>
                <div class="relative z-10">
                    <h2 class="font-display-lg text-headline-md md:text-display-lg text-white mb-6 font-extrabold">Siap
                        Meraih Prestasi Impianmu?</h2>
                    <p class="text-secondary-fixed text-lg mb-10 max-w-xl mx-auto">Konsultasikan kebutuhan belajarmu
                        dengan tim ahli kami secara gratis via WhatsApp.</p>
                    <a class="inline-flex items-center gap-3 bg-white text-primary px-10 py-5 rounded-full font-bold text-lg hover:bg-secondary-fixed transition-colors shadow-2xl"
                        href="https://wa.link/bmd9s5" target="_blank">
                        <svg class="w-6 h-6 fill-green-500" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.224-3.82c1.516.903 3.123 1.379 4.763 1.38h.005c5.333 0 9.674-4.34 9.677-9.674.002-2.586-1.003-5.015-2.83-6.841-1.827-1.827-4.255-2.831-6.842-2.831-5.334 0-9.675 4.341-9.677 9.675-.001 1.751.463 3.454 1.341 4.956l-.996 3.637 3.719-.976zm11.233-6.076c-.305-.152-1.805-.891-2.084-.993-.279-.101-.482-.152-.684.152-.203.304-.787.993-.965 1.194-.177.202-.355.228-.66.076-.304-.152-1.285-.474-2.447-1.511-.904-.806-1.514-1.802-1.691-2.105-.178-.304-.019-.468.133-.619.137-.136.305-.355.457-.533.151-.177.203-.304.304-.507.102-.202.051-.38-.025-.532-.076-.152-.684-1.648-.938-2.257-.247-.594-.499-.514-.684-.523-.177-.009-.38-.011-.583-.011s-.532.076-.811.38c-.279.304-1.065 1.039-1.065 2.535s1.09 2.94 1.242 3.143c.152.202 2.144 3.275 5.193 4.591.725.313 1.291.5 1.731.64.729.231 1.391.199 1.915.121.584-.087 1.805-.735 2.058-1.444.253-.709.253-1.317.177-1.444-.075-.127-.278-.203-.583-.355z">
                            </path>
                        </svg>
                        Hubungi Admin Sekarang
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-lowest border-t border-outline-variant py-section-gap w-full">
        <div
            class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto font-body-md text-body-md">
            <div>
                <a href="#hero" class="inline-block mb-6">
                    <img src="{{ asset($photos['logo']) }}" alt="Logo KAIFA" class="h-14 w-auto object-contain">
                </a>
                <p class="text-on-surface-variant mb-6">Partner terpercaya persiapan masa depan akademik siswa terbaik
                    di Malang.</p>
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/temankaifa?igsh=MWJ3bGJ6ZGEzY2V3dw==" target="_blank" class="text-primary hover:scale-110 transition-transform"><span
                            class="material-symbols-outlined">photo_camera</span></a>
                    <a href="mailto:temanbelajarkaifa@gmail.com" class="text-primary hover:scale-110 transition-transform"><span
                            class="material-symbols-outlined">alternate_email</span></a>
                    <a href="https://wa.link/bmd9s5" target="_blank" class="text-primary hover:scale-110 transition-transform"><span
                            class="material-symbols-outlined">call</span></a>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-primary mb-6">Quick Links</h4>
                <ul class="space-y-4">
                    <li><a class="text-on-surface-variant hover:text-secondary hover:translate-x-1 transition-transform inline-block"
                            href="#tentang">Tentang Kami</a></li>
                    <li><a class="text-on-surface-variant hover:text-secondary hover:translate-x-1 transition-transform inline-block"
                            href="#program">Program Unggulan</a></li>
                    <li><a class="text-on-surface-variant hover:text-secondary hover:translate-x-1 transition-transform inline-block"
                            href="#faq">Bantuan</a></li>
                    <li><a class="text-on-surface-variant hover:text-secondary hover:translate-x-1 transition-transform inline-block"
                            href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-primary mb-6">Kontak &amp; Alamat</h4>
                <div class="space-y-4 text-on-surface-variant">
                    <p class="flex gap-3">
                        <span class="material-symbols-outlined text-secondary">location_on</span>
                        Jl Brigjen Katamso No 195 Gedog Sananwetan Kota Blitar
                    </p>
                    <p class="flex gap-3">
                        <span class="material-symbols-outlined text-secondary">call</span>
                        <a href="https://wa.link/bmd9s5" target="_blank" class="hover:underline">wa.link/bmd9s5</a>
                    </p>
                    <p class="flex gap-3">
                        <span class="material-symbols-outlined text-secondary">mail</span>
                        <a href="mailto:temanbelajarkaifa@gmail.com" class="hover:underline">temanbelajarkaifa@gmail.com</a>
                    </p>
                </div>
            </div>
            <div>
                <h4 class="font-bold text-primary mb-6">Jam Operasional</h4>
                <div class="space-y-2 text-on-surface-variant">
                    <p class="font-bold">Senin - Sabtu</p>
                    <p>13.30 - 19.30 WIB</p>
                    <p class="mt-4 font-bold">Minggu</p>
                    <p>Tutup (Hanya kelas VIP)</p>
                </div>
            </div>
        </div>
        <div
            class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-section-gap pt-8 border-t border-outline-variant text-center text-on-surface-variant/80 text-sm">
            &copy; 2026 KAIFA Tutoring Center. All rights reserved.
        </div>
    </footer>


</body>

</html>