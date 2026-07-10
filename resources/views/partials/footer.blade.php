    <!-- ============================================================
         FOOTER — Apple footer component
         Background: #f5f5f7 (Parchment)
         Text: 12px / #7a7a7a
         Column headings: 14px / 600 / #1d1d1f
    ============================================================ -->
    <footer style="background-color: #f5f5f7; border-top: 1px solid #e0e0e0; padding-top: 64px; padding-bottom: 48px;">
        <div class="container-wide">
            <!-- Main footer columns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

                <!-- Brand Column -->
                <div>
                    <a href="#hero" class="inline-block mb-5" aria-label="KAIFA Home">
                        <img src="{{ asset($photos['logo']) }}" alt="Logo KAIFA" style="height: 32px; width: auto; object-fit: contain;">
                    </a>
                    <p class="t-fine-print mb-5" style="color: #7a7a7a; line-height: 1.5; max-width: 200px;">
                        Partner terpercaya persiapan masa depan akademik siswa terbaik di Malang.
                    </p>
                    <div class="flex gap-3">
                        <a href="https://www.instagram.com/temankaifa?igsh=MWJ3bGJ6ZGEzY2V3dw==" target="_blank" rel="noopener noreferrer"
                            class="social-link" aria-label="Instagram KAIFA">
                            <span class="material-symbols-outlined" style="font-size: 16px;">photo_camera</span>
                        </a>
                        <a href="mailto:temanbelajarkaifa@gmail.com"
                            class="social-link" aria-label="Email KAIFA">
                            <span class="material-symbols-outlined" style="font-size: 16px;">alternate_email</span>
                        </a>
                        <a href="https://wa.link/bmd9s5" target="_blank" rel="noopener noreferrer"
                            class="social-link" aria-label="WhatsApp KAIFA">
                            <span class="material-symbols-outlined" style="font-size: 16px;">call</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="t-caption-strong text-ink mb-3">Navigasi</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="#tentang" class="t-fine-print" style="color: #7a7a7a; text-decoration: none; line-height: 2.41; display: block; transition: color 0.15s;" onmouseover="this.style.color='#0066cc'" onmouseout="this.style.color='#7a7a7a'">Tentang Kami</a></li>
                        <li><a href="#program" class="t-fine-print" style="color: #7a7a7a; text-decoration: none; line-height: 2.41; display: block; transition: color 0.15s;" onmouseover="this.style.color='#0066cc'" onmouseout="this.style.color='#7a7a7a'">Program Unggulan</a></li>
                        <li><a href="#fasilitas" class="t-fine-print" style="color: #7a7a7a; text-decoration: none; line-height: 2.41; display: block; transition: color 0.15s;" onmouseover="this.style.color='#0066cc'" onmouseout="this.style.color='#7a7a7a'">Fasilitas</a></li>
                        <li><a href="#faq" class="t-fine-print" style="color: #7a7a7a; text-decoration: none; line-height: 2.41; display: block; transition: color 0.15s;" onmouseover="this.style.color='#0066cc'" onmouseout="this.style.color='#7a7a7a'">FAQ</a></li>
                        <li><a href="#testimoni" class="t-fine-print" style="color: #7a7a7a; text-decoration: none; line-height: 2.41; display: block; transition: color 0.15s;" onmouseover="this.style.color='#0066cc'" onmouseout="this.style.color='#7a7a7a'">Testimoni</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="t-caption-strong text-ink mb-3">Kontak &amp; Alamat</h4>
                    <div class="flex flex-col gap-3">
                        <div class="flex gap-2 items-start">
                            <span class="material-symbols-outlined" style="font-size: 14px; color: #7a7a7a; margin-top: 1px; flex-shrink: 0;">location_on</span>
                            <p class="t-fine-print" style="color: #7a7a7a; line-height: 1.5;">Jl Brigjen Katamso No 195 Gedog Sananwetan, Kota Blitar</p>
                        </div>
                        <div class="flex gap-2 items-center">
                            <span class="material-symbols-outlined" style="font-size: 14px; color: #7a7a7a; flex-shrink: 0;">call</span>
                            <a href="https://wa.link/bmd9s5" target="_blank" rel="noopener noreferrer"
                                class="t-fine-print" style="color: #0066cc; text-decoration: none;">wa.link/bmd9s5</a>
                        </div>
                        <div class="flex gap-2 items-center">
                            <span class="material-symbols-outlined" style="font-size: 14px; color: #7a7a7a; flex-shrink: 0;">mail</span>
                            <a href="mailto:temanbelajarkaifa@gmail.com"
                                class="t-fine-print" style="color: #0066cc; text-decoration: none;">temanbelajarkaifa@gmail.com</a>
                        </div>
                    </div>
                </div>

                <!-- Hours -->
                <div>
                    <h4 class="t-caption-strong text-ink mb-3">Jam Operasional</h4>
                    <div class="flex flex-col gap-2">
                        <div>
                            <p class="t-fine-print" style="color: #1d1d1f; font-weight: 600;">Senin – Sabtu</p>
                            <p class="t-fine-print" style="color: #7a7a7a; line-height: 2;">13.30 – 19.30 WIB</p>
                        </div>
                        <div>
                            <p class="t-fine-print" style="color: #1d1d1f; font-weight: 600;">Minggu</p>
                            <p class="t-fine-print" style="color: #7a7a7a; line-height: 2;">Tutup (Hanya kelas VIP)</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Legal row -->
            <div style="border-top: 1px solid #e0e0e0; padding-top: 20px; display: flex; flex-direction: column; gap: 8px; align-items: center; text-align: center;">
                <p class="t-fine-print" style="color: #7a7a7a;">Copyright &copy; 2026 KAIFA Tutoring Center. All rights reserved.</p>
                <div class="flex gap-5 flex-wrap justify-center">
                    <a href="#" class="t-fine-print" style="color: #7a7a7a; text-decoration: none;">Kebijakan Privasi</a>
                    <a href="#" class="t-fine-print" style="color: #7a7a7a; text-decoration: none;">Syarat &amp; Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
