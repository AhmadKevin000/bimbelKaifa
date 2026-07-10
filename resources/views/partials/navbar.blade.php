    <nav id="global-nav" aria-label="Navigasi utama">
        <div class="container-wide h-full flex items-center justify-between">
            <!-- Logo -->
            <a href="#hero" class="flex-shrink-0" aria-label="KAIFA Home">
                <img src="{{ asset($photos['logo']) }}" alt="Logo KAIFA" class="h-7 w-auto object-contain brightness-0 invert">
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center gap-6 t-nav-link">
                <a href="#tentang" class="hover:text-white transition-colors">Tentang Kami</a>
                <a href="#program" class="hover:text-white transition-colors">Program</a>
                <a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas</a>
                <a href="#faq" class="hover:text-white transition-colors">FAQ</a>
                <a href="#testimoni" class="hover:text-white transition-colors">Testimoni</a>
            </div>

            <!-- CTA + Hamburger -->
            <div class="flex items-center gap-4">
                <a href="https://wa.link/bmd9s5" target="_blank" rel="noopener noreferrer"
                    class="btn-primary hidden sm:inline-block"
                    style="padding: 7px 16px; font-size: 12px; letter-spacing: -0.12px;"
                    id="nav-cta">
                    Daftar Sekarang
                </a>
                <button id="mobile-menu-button" type="button"
                    class="w-11 h-11 flex items-center justify-center rounded-full md:hidden text-white/80 hover:text-white"
                    aria-label="Buka menu navigasi"
                    aria-expanded="false">
                    <span class="material-symbols-outlined" style="font-size: 22px;">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-drawer" class="flex-col px-6 py-6 gap-5 t-body border-t border-white/10 md:hidden">
            <a href="#tentang" class="text-white/85 hover:text-white py-1">Tentang Kami</a>
            <a href="#program" class="text-white/85 hover:text-white py-1">Program</a>
            <a href="#fasilitas" class="text-white/85 hover:text-white py-1">Fasilitas</a>
            <a href="#faq" class="text-white/85 hover:text-white py-1">FAQ</a>
            <a href="#testimoni" class="text-white/85 hover:text-white py-1">Testimoni</a>
            <a href="https://wa.link/bmd9s5" target="_blank" rel="noopener noreferrer"
                class="btn-primary mt-2 text-center">Daftar Sekarang</a>
        </div>
    </nav>
