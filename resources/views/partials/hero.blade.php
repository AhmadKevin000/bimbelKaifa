        <!-- ============================================================
             HERO SECTION — Full-width Background Banner
             Background: photo image + dark overlay (bg-black/65)
             Layout: center-aligned, no CTA buttons
             Stats: glassmorphism strip
        ============================================================ -->
        <section id="hero"
            class="relative flex flex-col items-center justify-center overflow-hidden min-h-screen"
            style="background-image: url('{{ asset($photos['hero']) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/65"></div>

            <!-- Content — centered, above overlay -->
            <div class="relative z-10 w-full flex flex-col items-center text-center px-6 py-20">

                <!-- Eyebrow label -->
                <p class="t-caption mb-6"
                    style="color: rgba(255,255,255,0.65); letter-spacing: 1px; text-transform: uppercase; font-weight: 600;">
                    SOLUSI BELAJAR CERDAS MASA KINI
                </p>

                <!-- Main Headline -->
                <h1 class="t-hero text-white mb-6" style="max-width: 820px; text-shadow: 0 2px 16px rgba(0,0,0,0.4);">
                    Bangun Fondasi Cerdas<br>Bersama&nbsp;<span style="color: #2997ff;">KAIFA</span>.
                </h1>

                <!-- Sub-headline -->
                <p class="t-lead-airy mb-12"
                    style="color: rgba(255,255,255,0.82); max-width: 750px;">
                    Temukan metode belajar seru dan personal untuk meningkatkan prestasi siswa di setiap semesternya.
                </p>

                <!-- Stats — Glassmorphism Strip -->
                <div class="flex flex-wrap items-center justify-center gap-0 rounded-2xl overflow-hidden"
                    style="background: rgba(255,255,255,0.10); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.18); box-shadow: 0 8px 32px rgba(0,0,0,0.25);">

                    <!-- Stat 1 -->
                    <div class="flex flex-col items-center px-10 py-6" style="border-right: 1px solid rgba(255,255,255,0.15);">
                        <p class="text-white font-semibold" style="font-size: 36px; line-height: 1; letter-spacing: -0.374px;">98%</p>
                        <p class="t-caption mt-2" style="color: rgba(255,255,255,0.65);">Tingkat Kepuasan</p>
                    </div>

                    <!-- Stat 2 -->
                    <div class="flex flex-col items-center px-10 py-6" style="border-right: 1px solid rgba(255,255,255,0.15);">
                        <p class="text-white font-semibold" style="font-size: 36px; line-height: 1; letter-spacing: -0.374px;">80+</p>
                        <p class="t-caption mt-2" style="color: rgba(255,255,255,0.65);">Siswa Aktif</p>
                    </div>

                    <!-- Stat 3 -->
                    <div class="flex flex-col items-center px-10 py-6">
                        <p class="text-white font-semibold" style="font-size: 36px; line-height: 1; letter-spacing: -0.374px;">3+</p>
                        <p class="t-caption mt-2" style="color: rgba(255,255,255,0.65);">Tahun pengalaman</p>
                    </div>

                </div>
            </div><!-- /content -->

        </section>
