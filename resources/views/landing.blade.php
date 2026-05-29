<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kaifa Bimbel | Teman Belajar</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&family=Poppins:wght@400;500;600;700&family=ABeeZee&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        .font-nunito { font-family: 'Nunito Sans', sans-serif; }
        .font-abeezee { font-family: 'ABeeZee', sans-serif; }
        
        /* Custom Gradient Background Header disamakan dengan Footer */
        .bg-hero-gradient {
            background: linear-gradient(180deg, #e0f2fe 0%, #7dd3fc 100%);
            border-bottom-left-radius: 50% 15%;
            border-bottom-right-radius: 50% 15%;
        }
        
        /* Slider Animation */
        .slide-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased">

    <nav class="fixed w-full bg-white z-50 shadow-sm">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32">
            <div class="flex justify-between items-center h-28">
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('images/Kaifa.png') }}" alt="Logo Kaifa" class="h-16 w-auto object-contain">
                </div>

                <div class="hidden lg:flex space-x-12">
                    <a href="#hero" class="text-black text-xl font-normal tracking-wide hover:text-sky-600 transition">Beranda</a>
                    <a href="#program" class="text-black text-xl font-normal tracking-wide hover:text-sky-600 transition">Program</a>
                    <a href="#keunggulan" class="text-black text-xl font-normal tracking-wide hover:text-sky-600 transition">Keunggulan</a>
                    <a href="#testimoni" class="text-black text-xl font-normal tracking-wide hover:text-sky-600 transition">Testimoni</a>
                    <a href="#footer" class="text-black text-xl font-normal tracking-wide hover:text-sky-600 transition">Tentang Kami</a>
                </div>

                <div class="lg:hidden flex items-center">
                    <button class="text-gray-600 hover:text-sky-600 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <section id="hero" class="relative pt-36 pb-32 bg-hero-gradient">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-left mt-20">
                    <h1 class="text-5xl lg:text-[64px] font-bold leading-tight mb-8">
                        <span class="text-amber-500 drop-shadow-sm">Belajar Lebih Mudah</span><br />
                        <span class="text-indigo-900 drop-shadow-sm">Bersama Kaifa</span>
                    </h1>
                    <p class="text-slate-700 text-xl md:text-2xl font-nunito leading-relaxed max-w-2xl">
                        Kaifa hadir sebagai teman belajar terpercaya untuk anak-anak dari usia dini hingga persiapan ujian masuk perguruan tinggi.
                    </p>
                </div>
                <div class="relative w-full flex justify-end">
                    <img src="{{ asset('images/hero-siswa.png') }}" alt="Siswa SMA" class="w-full max-w-[770px] h-auto object-cover rounded-3xl z-10">
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white mt-10">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32">
            <div class="text-center mb-16">
                <h2 class="text-indigo-900 text-4xl md:text-5xl font-bold font-nunito mb-6">Keberhasilan Kami</h2>
                <p class="text-gray-500 text-xl max-w-3xl mx-auto leading-relaxed">Kami terus berkomitmen menghadirkan pendidikan berkualitas dan telah dipercaya oleh ratusan keluarga sejak awal berdiri.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-16 lg:gap-32 text-center mt-20">
                <div class="flex flex-col items-center">
                    <div class="text-sky-700 text-7xl lg:text-8xl font-light mb-4">80+</div>
                    <div class="text-slate-950/80 text-2xl lg:text-3xl font-abeezee">Siswa Aktif</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-sky-700 text-7xl lg:text-8xl font-light mb-4">3</div>
                    <div class="text-slate-950/80 text-2xl lg:text-3xl font-abeezee">Program Unggulan</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-sky-700 text-7xl lg:text-8xl font-light mb-4">15+</div>
                    <div class="text-slate-950/80 text-2xl lg:text-3xl font-abeezee">Pengajar</div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-sky-700 text-7xl lg:text-8xl font-light mb-4">±5</div>
                    <div class="text-slate-950/80 text-2xl lg:text-3xl font-abeezee">Tahun Berdiri</div>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="py-24 bg-white">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32">
            <div class="text-center mb-20">
                <h2 class="text-indigo-900 text-4xl md:text-5xl font-bold font-nunito mb-6">Program Kami</h2>
                <p class="text-gray-500 text-xl max-w-3xl mx-auto leading-relaxed">Kami menyediakan program belajar yang terstruktur dan menyenangkan untuk semua jenjang, mulai dari usia dini hingga persiapan ujian.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-24">
                <div class="bg-white rounded-[40px] shadow-[0px_10px_60px_0px_rgba(38,45,118,0.08)] p-12 text-center relative pt-24 mt-12">
                    <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-indigo-500 rounded-full flex items-center justify-center shadow-[0px_10px_40px_0px_rgba(54,61,136,0.06)]">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-indigo-900 text-3xl font-medium mb-6 mt-4">Calistung AHe</h3>
                    <p class="text-gray-500 text-xl leading-9">Program membaca, menulis, dan berhitung untuk anak usia dini agar siap memasuki jenjang sekolah dasar.</p>
                </div>
                <div class="bg-white rounded-[40px] shadow-[0px_10px_60px_0px_rgba(38,45,118,0.08)] p-12 text-center relative pt-24 mt-12">
                    <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-teal-500 rounded-full flex items-center justify-center shadow-[0px_16px_40px_0px_rgba(37,44,113,0.10)]">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-indigo-900 text-3xl font-medium mb-6 mt-4">Reguler Kelas 1–12</h3>
                    <p class="text-gray-500 text-xl leading-9">Bimbingan belajar semua mata pelajaran untuk siswa SD, SMP, hingga SMA sesuai kurikulum nasional.</p>
                </div>
                <div class="bg-white rounded-[40px] shadow-[0px_10px_60px_0px_rgba(38,45,118,0.08)] p-12 text-center relative pt-24 mt-12">
                    <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-sky-400 rounded-full flex items-center justify-center shadow-[0px_10px_40px_0px_rgba(54,61,136,0.06)]">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-indigo-900 text-3xl font-medium mb-6 mt-4">TKA</h3>
                    <p class="text-gray-500 text-xl leading-9">Persiapan intensif Tes Kemampuan Akademik untuk seleksi masuk perguruan tinggi negeri favorit.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="py-24 bg-white">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32">
            <div class="text-center mb-32">
                <h2 class="text-indigo-900 text-4xl md:text-5xl font-bold font-nunito mb-6">Keunggulan Kami</h2>
                <p class="text-gray-500 text-xl max-w-3xl mx-auto leading-relaxed">Kami dapat membuat kegiatan pembelajaran menjadi lebih efisien.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-40 relative">
                <div class="order-2 lg:order-1 relative w-full px-6 md:px-12 lg:px-0 z-10">
                    <div class="absolute -top-8 -left-2 md:-left-8 w-28 h-28 md:w-36 md:h-36 bg-emerald-400 rounded-full opacity-60 z-0"></div>
                    <div class="absolute -bottom-8 -right-2 md:-right-8 w-40 h-40 md:w-48 md:h-48 bg-indigo-500 rounded-full opacity-60 z-0"></div>
                    <img src="{{ asset('images/keunggulan1.png') }}" alt="Lingkungan Belajar Terfokus" class="w-full h-[350px] md:h-[450px] object-cover rounded-[40px] shadow-2xl relative z-20">
                </div>
                <div class="order-1 lg:order-2 pl-0 lg:pl-10 relative z-20">
                    <h3 class="text-indigo-900 text-3xl md:text-4xl font-semibold mb-6 leading-snug">Lingkungan Belajar<br/>Kondusif & Terfokus</h3>
                    <p class="text-gray-500 text-xl leading-relaxed tracking-wide">
                        Kami memahami bahwa setiap siswa memiliki kecepatan belajar yang berbeda. Dengan membatasi kapasitas ruang kelas, pengajar kami dapat memberikan perhatian yang lebih optimal untuk mendukung perkembangan dan keunikan gaya belajar setiap anak.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-40 relative">
                <div class="order-1 lg:order-1 pr-0 lg:pr-10 relative z-20">
                    <h3 class="text-indigo-900 text-3xl md:text-4xl font-semibold mb-6 leading-snug">Laporan Perkembangan<br/>yang Transparan</h3>
                    <p class="text-gray-500 text-xl leading-relaxed tracking-wide">
                        Orang tua dapat memantau hasil belajar anak dengan tenang dan nyaman. Melalui laporan perkembangan berkala yang disusun langsung oleh guru pengajar, Ayah & Bunda bisa melihat capaian akademik, tingkat kehadiran, serta evaluasi belajar anak secara jelas.
                    </p>
                </div>
                <div class="order-2 lg:order-2 relative w-full px-6 md:px-12 lg:px-0 z-10">
                    <div class="absolute -top-8 -right-2 md:-right-8 w-32 h-32 md:w-40 md:h-40 bg-red-400 rounded-full opacity-60 z-0"></div>
                    <div class="absolute -bottom-6 -left-2 md:-left-6 w-20 h-20 bg-orange-300 rounded-full opacity-70 z-0"></div>
                    <img src="{{ asset('images/keunggulan2.png') }}" alt="Laporan Transparan" class="w-full h-[350px] md:h-[450px] object-cover rounded-[40px] shadow-2xl relative z-20">
                    
                    <div class="absolute -top-6 -left-6 md:-left-12 w-20 h-20 bg-white rounded-[20px] shadow-xl rotate-[-12deg] flex items-center justify-center z-30">
                        <div class="w-16 h-16 bg-white rounded-[20px] flex flex-col gap-1.5 items-center justify-center p-2">
                             <div class="w-8 h-2 bg-indigo-500 rounded"></div>
                             <div class="w-6 h-2 bg-amber-500 rounded self-start ml-2"></div>
                             <div class="w-10 h-2 bg-indigo-500 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center relative">
                <div class="order-2 lg:order-1 relative w-full px-6 md:px-12 lg:px-0 z-10">
                    <div class="absolute -top-8 -left-2 md:-left-6 w-28 h-28 md:w-36 md:h-36 bg-indigo-500 rounded-full opacity-70 z-0"></div>
                    <div class="absolute -bottom-8 -right-2 md:-right-6 w-24 h-24 bg-emerald-400 rounded-full opacity-60 z-0"></div>
                    <img src="{{ asset('images/keunggulan3.png') }}" alt="Kurikulum Relevan" class="w-full h-[350px] md:h-[450px] object-cover rounded-[40px] shadow-2xl relative z-20">
                    
                    <div class="absolute -top-8 right-[5%] w-20 h-20 bg-white rounded-full shadow-xl flex items-center justify-center border-[3px] border-pink-600 z-30">
                         <div class="w-8 h-8 rounded-full border-[3px] border-pink-400"></div>
                    </div>
                </div>
                <div class="order-1 lg:order-2 pl-0 lg:pl-10 relative z-20">
                    <h3 class="text-indigo-900 text-3xl md:text-4xl font-semibold mb-6 leading-snug">Kurikulum Relevan &<br/>Siap Ujian</h3>
                    <p class="text-gray-500 text-xl leading-relaxed tracking-wide">
                        Materi pembelajaran di Kaifa dirancang agar selalu selaras dengan kurikulum sekolah nasional. Kami fokus memperkuat pemahaman konsep dasar siswa, sekaligus memberikan persiapan yang matang untuk menghadapi berbagai ujian harian maupun seleksi masuk PTN.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimoni" class="py-32 bg-white relative overflow-hidden">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32 relative z-10">
            <div class="text-center mb-16 relative">
                <span class="text-slate-500 text-xl font-nunito tracking-[4px] uppercase mb-4 block">TESTIMONIA</span>
                <h2 class="text-indigo-900 text-4xl md:text-5xl font-bold font-nunito mb-6">Apa Pendapat Mereka?</h2>
            </div>
            
            <div class="relative w-full max-w-5xl mx-auto px-16 lg:px-24">
                
                <button id="prev-btn" class="absolute left-0 top-1/2 transform -translate-y-1/2 w-16 h-16 bg-white rounded-full shadow-[0px_4px_40px_0px_rgba(41,44,124,0.15)] flex items-center justify-center hover:scale-105 transition group cursor-pointer border-[3px] border-transparent hover:border-cyan-500 z-30">
                    <svg class="w-8 h-8 text-cyan-500 group-hover:text-cyan-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <div class="relative w-full overflow-hidden bg-white rounded-[20px] shadow-[2px_10px_60px_0px_rgba(41,44,124,0.08)]">
                    <div class="absolute left-0 top-0 bottom-0 w-3.5 bg-red-400 rounded-tl-[20px] rounded-bl-[20px] z-20"></div>
                    
                    <div id="slider-track" class="slide-track w-full">
                        
                        <div class="w-full flex-shrink-0 p-8 md:p-12 pl-12 md:pl-20 min-h-[300px] flex flex-col justify-between">
                            <p class="text-gray-500 text-xl font-nunito leading-10 tracking-wide mb-8">
                                "Alhamdulillah senang belajar disini karena dekat dengan rumah. Jadi kalau gak bisa antar jemput anak bs jalan kaki 🙏"
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                    <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-500 font-bold">A</div>
                                </div>
                                <div>
                                    <h4 class="text-gray-500 text-2xl font-semibold font-nunito">awa dliyafa</h4>
                                    <p class="text-gray-500 text-base font-nunito">Orang Tua Murid</p>
                                </div>
                                <div class="ml-auto flex text-amber-400 text-xl">★★★★★</div>
                            </div>
                        </div>
                        
                        <div class="w-full flex-shrink-0 p-8 md:p-12 pl-12 md:pl-20 min-h-[300px] flex flex-col justify-between">
                            <p class="text-gray-500 text-xl font-nunito leading-10 tracking-wide mb-8">
                                "anak sy lebih senang belajar di bimbel dr pd sama saya. Katanya mbak-mbaknya enak jelasinnya dr pd saya 😅"
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                    <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-500 font-bold">M</div>
                                </div>
                                <div>
                                    <h4 class="text-gray-500 text-2xl font-semibold font-nunito">Muhammad Ali M.K</h4>
                                    <p class="text-gray-500 text-base font-nunito">Orang Tua Murid</p>
                                </div>
                                <div class="ml-auto flex text-amber-400 text-xl">★★★★★</div>
                            </div>
                        </div>

                        <div class="w-full flex-shrink-0 p-8 md:p-12 pl-12 md:pl-20 min-h-[300px] flex flex-col justify-between">
                            <p class="text-gray-500 text-xl font-nunito leading-10 tracking-wide mb-8">
                                "Gurunya asik, belajar menjadi menyenangkan. Semoga cita² ku tercapai😱😱"
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                    <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-500 font-bold">N</div>
                                </div>
                                <div>
                                    <h4 class="text-gray-500 text-2xl font-semibold font-nunito">Naufal_XD</h4>
                                    <p class="text-gray-500 text-base font-nunito">Siswa</p>
                                </div>
                                <div class="ml-auto flex text-amber-400 text-xl">★★★★★</div>
                            </div>
                        </div>

                        <div class="w-full flex-shrink-0 p-8 md:p-12 pl-12 md:pl-20 min-h-[300px] flex flex-col justify-between">
                            <p class="text-gray-500 text-xl font-nunito leading-10 tracking-wide mb-8">
                                "belajar di kaifa sangat seruu🤩🤩😍😍🤩"
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                    <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-500 font-bold">O</div>
                                </div>
                                <div>
                                    <h4 class="text-gray-500 text-2xl font-semibold font-nunito">oziie</h4>
                                    <p class="text-gray-500 text-base font-nunito">Siswa</p>
                                </div>
                                <div class="ml-auto flex text-amber-400 text-xl">★★★★★</div>
                            </div>
                        </div>

                    </div>
                </div>
                
                <button id="next-btn" class="absolute right-0 top-1/2 transform -translate-y-1/2 w-16 h-16 bg-white rounded-full shadow-[0px_4px_40px_0px_rgba(41,44,124,0.15)] flex items-center justify-center hover:scale-105 transition group cursor-pointer border-[3px] border-transparent hover:border-cyan-500 z-30">
                    <svg class="w-8 h-8 text-cyan-500 group-hover:text-cyan-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>

    <footer id="footer" class="relative pt-16 pb-8 bg-gradient-to-b from-sky-100 to-sky-300 border-t border-sky-100">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-10 lg:px-32 relative z-10">
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-10 mb-12">
                <div class="flex justify-center md:justify-start">
                    <img src="{{ asset('images/Kaifa.png') }}" alt="Logo Kaifa" class="h-24 w-auto object-contain drop-shadow-sm">
                </div>

                <div class="text-center md:text-right">
                    <h4 class="text-slate-900 text-2xl font-bold mb-4">Kontak Kami</h4>
                    <p class="text-slate-800 text-xl mb-2 hover:text-indigo-900 transition cursor-pointer">Whatsapp 0852-3216-9460</p>
                    <p class="text-slate-800 text-xl hover:text-indigo-900 transition cursor-pointer">Instagram @temankaifa</p>
                </div>
            </div>
            
            <div class="border-t border-sky-400/40 pt-8 text-center md:text-left">
                <p class="text-slate-900 text-lg font-medium">© 2026 Teman Belajar Kaifa. All rights reserved</p>
            </div>
            
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('slider-track');
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            let currentSlide = 0;
            const totalSlides = 4; // Total 4 Ulasan

            // Tombol Maju
            nextBtn.addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            });

            // Tombol Mundur
            prevBtn.addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlider();
            });

            function updateSlider() {
                const slideWidth = 100; // Geser per 100% dari lebar container
                track.style.transform = `translateX(-${currentSlide * slideWidth}%)`;
            }
        });
    </script>
</body>
</html>