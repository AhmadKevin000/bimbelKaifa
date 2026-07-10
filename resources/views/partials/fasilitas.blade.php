        <!-- ============================================================
            FACILITIES SECTION — product-tile-light
            Background: #ffffff
            Icon containers: hairline border, no shadow
        ============================================================ -->
        <section id="fasilitas" class="tile-white section-pad">
            <div class="container-wide">
                <!-- Pembungkus Grid Utama (Kiri Teks, Kanan Gambar) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <!-- KOLOM KIRI: Teks & Ikon -->
                    <div>
                        <p class="t-caption text-ink-muted mb-4" style="letter-spacing: 0.6px; text-transform: uppercase; font-weight: 600;">
                            Fasilitas
                        </p>
                        <h2 class="t-display-lg text-ink mb-4">Lingkungan Belajar Kondusif</h2>
                        <p class="t-lead-airy mb-12" style="color: #333333;">
                            Kami percaya suasana yang nyaman, aman, dan kekeluargaan adalah kunci agar anak lebih fokus dan betah belajar.
                        </p>

                        <!-- Grid untuk 4 Fasilitas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <!-- Poin 1 -->
                            <div class="flex gap-4">
                                <div class="facility-icon">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">description</span>
                                </div>
                                <div>
                                    <h4 class="t-body-strong text-ink mb-1">Laporan Evaluasi Berkala</h4>
                                    <p class="t-caption" style="color: #7a7a7a; line-height: 1.5;">Pantau perkembangan dan nilai anak melalui laporan rutin yang transparan.</p>
                                </div>
                            </div>
                            <!-- Poin 2 -->
                            <div class="flex gap-4">
                                <div class="facility-icon">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">home</span>
                                </div>
                                <div>
                                    <h4 class="t-body-strong text-ink mb-1">Suasana Homey & Aman</h4>
                                    <p class="t-caption" style="color: #7a7a7a; line-height: 1.5;">Ruang belajar tenang dan bersih layaknya di rumah sendiri agar anak tidak tegang.</p>
                                </div>
                            </div>
                            <!-- Poin 3 -->
                            <div class="flex gap-4">
                                <div class="facility-icon">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">person</span>
                                </div>
                                <div>
                                    <h4 class="t-body-strong text-ink mb-1">Pengajar Sabar & Ramah</h4>
                                    <p class="t-caption" style="color: #7a7a7a; line-height: 1.5;">Tutor telaten yang mengedepankan kedekatan emosional dengan setiap anak.</p>
                                </div>
                            </div>
                            <!-- Poin 4 -->
                            <div class="flex gap-4">
                                <div class="facility-icon">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">groups</span>
                                </div>
                                <div>
                                    <h4 class="t-body-strong text-ink mb-1">Kelompok Belajar Kecil</h4>
                                    <p class="t-caption" style="color: #7a7a7a; line-height: 1.5;">Kapasitas kelas dibatasi agar setiap anak mendapat perhatian penuh dari tutor.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: Image Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-4">
                            <img src="{{ asset($photos['facility_1']) }}"
                                alt="Fasilitas KAIFA 1"
                                class="w-full product-shadow"
                                style="border-radius: 14px; height: 200px; object-fit: cover;"
                                loading="lazy">
                            <img src="{{ asset($photos['facility_2']) }}"
                                alt="Fasilitas KAIFA 2"
                                class="w-full product-shadow"
                                style="border-radius: 14px; height: 152px; object-fit: cover;"
                                loading="lazy">
                        </div>
                        <div class="flex flex-col gap-4" style="padding-top: 28px;">
                            <img src="{{ asset($photos['facility_3']) }}"
                                alt="Fasilitas KAIFA 3"
                                class="w-full product-shadow"
                                style="border-radius: 14px; height: 152px; object-fit: cover;"
                                loading="lazy">
                            <img src="{{ asset($photos['facility_4']) }}"
                                alt="Fasilitas KAIFA 4"
                                class="w-full product-shadow"
                                style="border-radius: 14px; height: 200px; object-fit: cover;"
                                loading="lazy">
                        </div>
                    </div>

                </div>
            </div>
        </section>
