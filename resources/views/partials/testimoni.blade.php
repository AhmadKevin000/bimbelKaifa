        <!-- ============================================================
             TESTIMONIALS SECTION — product-tile-dark
             Background: #272729 (near-black tile)
             White text on dark
        ============================================================ -->
        <section id="testimoni" class="tile-dark section-pad" style="overflow: hidden;">
            <div class="container-wide">
                <div class="text-center mb-14">
                    <p class="t-caption mb-4" style="color: #7a7a7a; letter-spacing: 0.6px; text-transform: uppercase; font-weight: 600;">
                        Testimoni
                    </p>
                    <h2 class="t-display-lg" style="color: #ffffff;">Apa Kata Mereka?</h2>
                </div>

                <!-- Slider -->
                <div class="relative overflow-hidden" id="testimonial-slider">
                    <div class="flex w-full" id="slider-track" style="transform: translateX(0%); transition: transform 0.8s ease-in-out;">

                        <!-- Slide 1 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div class="mx-auto" style="max-width: 680px;">
                                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 18px; padding: 40px;">
                                    <!-- Stars -->
                                    <div class="flex gap-1 mb-6 justify-center">
                                        <span style="color: #f5c518; font-size: 16px;">★★★★★</span>
                                    </div>
                                    <p class="t-lead text-center mb-8" style="color: #ffffff; font-weight: 300; font-size: 20px; line-height: 1.5; font-style: italic;">
                                        "Awalnya khawatir anak susah diajarin baca. Tapi berkat pendekatan belajar sambil bermain di KAIFA, baru sebulan anak saya udah mulai lancar ngeja huruf. Puas banget sama pelayanannya."
                                    </p>
                                    <div class="flex items-center justify-center gap-4">
                                        <div style="width: 48px; height: 48px; border-radius: 9999px; background: #0066cc; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px; flex-shrink: 0;">
                                            P
                                        </div>
                                        <div class="text-left">
                                            <p class="t-body-strong" style="color: #ffffff;">Pak Dimas</p>
                                            <p class="t-caption" style="color: #7a7a7a;">Orang Tua Siswa TK B</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div class="mx-auto" style="max-width: 680px;">
                                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 18px; padding: 40px;">
                                    <div class="flex gap-1 mb-6 justify-center">
                                        <span style="color: #f5c518; font-size: 16px;">★★★★★</span>
                                    </div>
                                    <p class="t-lead text-center mb-8" style="color: #ffffff; font-weight: 300; font-size: 20px; line-height: 1.5; font-style: italic;">
                                        "Belajar di KAIFA itu seru banget, ngga ngebosenin kayak di sekolah. Kelasnya nyaman, dan kakak-kakak tutornya asik diajak diskusi. Matematika yang awalnya susah jadi kerasa gampang."
                                    </p>
                                    <div class="flex items-center justify-center gap-4">
                                        <div style="width: 48px; height: 48px; border-radius: 9999px; background: #0066cc; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px; flex-shrink: 0;">
                                            K
                                        </div>
                                        <div class="text-left">
                                            <p class="t-body-strong" style="color: #ffffff;">Kinan</p>
                                            <p class="t-caption" style="color: #7a7a7a;">Siswa Kelas 8 SMP</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="w-full flex-shrink-0 px-4">
                            <div class="mx-auto" style="max-width: 680px;">
                                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 18px; padding: 40px;">
                                    <div class="flex gap-1 mb-6 justify-center">
                                        <span style="color: #f5c518; font-size: 16px;">★★★★★</span>
                                    </div>
                                    <p class="t-lead text-center mb-8" style="color: #ffffff; font-weight: 300; font-size: 20px; line-height: 1.5; font-style: italic;">
                                        "Alhamdulillah, sejak les di KAIFA, anak saya jadi lebih mandiri ngerjain PR. Kalau ada materi sekolah yang belum paham, tutornya selalu sabar ngejelasin sampai ngerti. Nilai PTS kemarin naik drastis!"
                                    </p>
                                    <div class="flex items-center justify-center gap-4">
                                        <div style="width: 48px; height: 48px; border-radius: 9999px; background: #0066cc; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 18px; flex-shrink: 0;">
                                            B
                                        </div>
                                        <div class="text-left">
                                            <p class="t-body-strong" style="color: #ffffff;">Bunda Raya</p>
                                            <p class="t-caption" style="color: #7a7a7a;">Orang Tua Siswa Kelas 5 SD</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Dots -->
                <div class="flex justify-center gap-2 mt-8">
                    <button class="w-2 h-2 rounded-full transition-all" id="dot-0"
                        style="background: #ffffff;" onclick="moveSlider(0)" aria-label="Testimoni 1"></button>
                    <button class="w-2 h-2 rounded-full transition-all" id="dot-1"
                        style="background: rgba(255,255,255,0.3);" onclick="moveSlider(1)" aria-label="Testimoni 2"></button>
                    <button class="w-2 h-2 rounded-full transition-all" id="dot-2"
                        style="background: rgba(255,255,255,0.3);" onclick="moveSlider(2)" aria-label="Testimoni 3"></button>
                </div>
            </div>
        </section>
