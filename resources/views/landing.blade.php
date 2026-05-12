<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kaifa Bimbel | Teman Belajar</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
            </div>
        </div>
    </nav>

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
            </div>
        </div>
    </section>

    <section class="py-20 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-100 rounded-full z-0"></div>
                    <img src="{{ asset('images/pantau-akademik.png') }}" alt="Perkembangan Akademik" class="relative rounded-3xl shadow-xl w-full object-cover z-10">
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-3xl md:text-4xl font-bold text-indigo-900 mb-6 leading-tight">Pantau Perkembangan Belajar Lebih Transparan</h2>
                    <p class="text-lg text-gray-500 mb-6 leading-relaxed">
                        Kami tidak hanya memberikan pengajaran terbaik, tetapi juga didukung oleh Sistem Informasi Manajemen terpadu. Jadwal bimbingan, riwayat kehadiran kelas (Reguler, Intensif, Private), hingga evaluasi materi terpantau dengan jelas.
                    </p>
                    <a href="#" class="text-sky-600 font-medium underline text-lg hover:text-sky-800 transition">Lihat Fasilitas Kami</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">
                    <span class="text-indigo-900">Keunggulan</span> <span class="text-teal-500">Kami</span>
                </h2>
                <p class="text-gray-500 text-xl font-medium max-w-2xl mx-auto">
                    Kami dapat membuat kegiatan pembelajaran menjadi lebih efisien.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
                <div class="relative">
                    <div class="absolute -top-8 -left-8 w-32 h-32 bg-indigo-100 rounded-full z-0"></div>
                    <img src="{{ asset('images/fitur-interaktif.png') }}" alt="Lingkungan Belajar Terfokus" class="relative rounded-3xl shadow-xl w-full object-cover z-10 border border-white/50">
                </div>
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold text-indigo-900 mb-6 leading-tight">Lingkungan Belajar Terfokus & Interaktif</h3>
                    <p class="text-lg text-gray-500 leading-relaxed">
                        Kami menyediakan ruang belajar yang kondusif, didukung dengan teknologi untuk memastikan interaksi antara pengajar dan siswa tetap berjalan efektif dan menyenangkan, layaknya belajar privat.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <h3 class="text-3xl md:text-4xl font-bold text-indigo-900 mb-6 leading-tight">Fokus pada Materi yang Paling Dibutuhkan</h3>
                    <p class="text-lg text-gray-500 leading-relaxed">
                        Setiap siswa memiliki tantangan akademik yang berbeda. Oleh karena itu, kami memfasilitasi siswa untuk memilih dan fokus pada kelas mata pelajaran spesifik yang paling ingin mereka kuasai untuk mendongkrak nilai rapor atau persiapan ujian.
                    </p>
                </div>
                <div class="order-1 lg:order-2 relative">
                    <div class="absolute -bottom-8 -right-8 w-32 h-32 bg-pink-100 rounded-full z-0"></div>
                    <img src="{{ asset('images/fitur-materi.png') }}" alt="Fokus Materi Belajar" class="relative rounded-3xl shadow-xl w-full object-cover z-10 border border-white/50">
                </div>
            </div>
            
            <div class="mt-20 flex justify-center">
                <a href="#" class="px-8 py-4 rounded-full border-2 border-teal-400 text-teal-500 font-bold text-lg hover:bg-teal-50 transition">
                    Lihat lebih banyak fitur
                </a>
            </div>
        </div>
    </section>

    <section id="testimoni" class="py-24 bg-sky-50 rounded-t-[3rem] lg:rounded-t-[8rem]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sky-600 font-bold tracking-widest uppercase text-sm mb-2 block font-nunito">Testimoni</span>
                <h2 class="text-4xl md:text-5xl font-bold text-indigo-900">Apa Pendapat Mereka?</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">
                <div>
                    <img src="{{ asset('images/testimoni.png') }}" alt="Student" class="rounded-3xl shadow-xl w-full object-cover">
                </div>
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-lg relative lg:-ml-20 z-10">
                    <div class="flex text-amber-400 mb-4 text-xl">
                        ★★★★★
                    </div>
                    <p class="text-lg text-gray-600 italic mb-8 leading-relaxed font-nunito">
                        "Terima kasih banyak atas fasilitas yang diberikan. Sistem informasi Kaifa sangat memudahkan saya sebagai orang tua untuk memantau nilai dan jadwal les anak saya secara langsung dari HP. Sangat transparan dan profesional!"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="text-left">
                            <h4 class="font-bold text-indigo-900 text-xl font-nunito">Bambang</h4>
                            <p class="text-gray-500 text-sm">Orang Tua Siswa Reguler</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-indigo-950 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white p-3 rounded-2xl mb-8 inline-block">
                <img src="{{ asset('images/Kaifa.png') }}" alt="Logo Kaifa" class="h-12 w-auto object-contain">
            </div>
            
            <div class="flex flex-col md:flex-row justify-center items-center gap-6 mb-8">
                <a href="#" class="text-slate-300 hover:text-white transition">Beranda</a>
                <a href="#keunggulan" class="text-slate-300 hover:text-white transition">Keunggulan</a>
                <a href="#program" class="text-slate-300 hover:text-white transition">Program</a>
                <a href="#testimoni" class="text-slate-300 hover:text-white transition">Testimoni</a>
            </div>

            <div class="border-t border-indigo-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-sm">
                <p>&copy; 2026 Kaifa Bimbel. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>