        <!-- ============================================================
             ABOUT SECTION — product-tile-light
             Background: #ffffff (White)
             Clean 2-col layout, Visi/Misi as store-utility-card
        ============================================================ -->
        <section id="tentang" class="tile-white section-pad">
            <div class="container-wide">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <!-- Image -->
                    <div>
                        <img src="{{ asset($photos['about']) }}"
                            alt="Suasana belajar di KAIFA Tutoring Center"
                            class="w-full product-shadow"
                            style="border-radius: 18px; object-fit: cover; height: 460px;"
                            loading="lazy">
                    </div>
                    <!-- Text -->
                    <div>
                        <p class="t-caption text-ink-muted mb-4" style="letter-spacing: 0.6px; text-transform: uppercase; font-weight: 600;">
                            Tentang Kami
                        </p>
                        <h2 class="t-display-lg text-ink mb-6">
                            KAIFA Tutoring Center
                        </h2>
                        <p class="t-lead-airy text-ink mb-10" style="color: #333333;">
                            KAIFA (Karya Inspirasi Family) adalah pusat bimbingan belajar yang lahir dari semangat untuk memberikan pendidikan berkualitas yang personal dan menyenangkan. Kami percaya setiap anak memiliki potensi unik yang perlu diasah dengan metode yang tepat.
                        </p>

                        <!-- Visi & Misi Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="utility-card program-card">
                                <div class="facility-icon mb-4">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">visibility</span>
                                </div>
                                <h3 class="t-body-strong text-ink mb-2">Visi Kami</h3>
                                <p class="t-caption" style="color: #7a7a7a; line-height: 1.5;">
                                    Menjadi pusat keunggulan akademik yang mencetak generasi cerdas, berkarakter, dan siap bersaing di tingkat global.
                                </p>
                            </div>
                            <div class="utility-card program-card">
                                <div class="facility-icon mb-4">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">flag</span>
                                </div>
                                <h3 class="t-body-strong text-ink mb-2">Misi Kami</h3>
                                <p class="t-caption" style="color: #7a7a7a; line-height: 1.5;">
                                    Mendampingi setiap siswa mencapai prestasi terbaiknya melalui pendekatan humanis dan kurikulum adaptif.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
