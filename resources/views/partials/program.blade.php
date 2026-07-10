        <!-- ============================================================
             PROGRAMS SECTION — product-tile-parchment
             Background: #f5f5f7
             Cards: store-utility-card style (white, hairline border, 18px radius)
        ============================================================ -->
        <section id="program" class="tile-parchment section-pad">
            <div class="container-wide">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <p class="t-caption text-ink-muted mb-4" style="letter-spacing: 0.6px; text-transform: uppercase; font-weight: 600;">
                        Program Belajar
                    </p>
                    <h2 class="t-display-lg text-ink mb-4">Program Unggulan Kami</h2>
                    <p class="t-lead-airy mx-auto" style="color: #7a7a7a; max-width: 520px;">
                        Pilih paket belajar yang paling sesuai dengan kebutuhan dan target akademikmu.
                    </p>
                </div>

                <!-- Program Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    @php
                    /**
                     * Dummy fitur per program — ganti/tambah sesuai kebutuhan.
                     * Key harus sama persis (case-insensitive) dengan program->nama di DB.
                     */
                    $fiturProgram = [
                        'calistung' => [
                            'Belajar membaca, menulis & berhitung',
                            'Metode belajar interaktif',
                            'Pendekatan personal sesuai karakter anak',
                            'Membangun rasa percaya diri anak',
                        ],
                        'reguler'   => [
                            'Pendampingan PR & tugas sekolah',
                            'Persiapan Ulangan Harian, PTS & PAS',
                            'Pendalaman konsep materi pelajaran',
                            'Laporan evaluasi belajar berkala',
                        ],
                        'tka'       => [
                            'Fokus penguatan Literasi & Numerasi (AKM)',
                            'Latihan soal penalaran & logika dasar',
                            'Persiapan seleksi masuk SMP/SMA Favorit',
                            'Simulasi tes akademik secara berkala',
                        ],
                    ];
                    @endphp

                    @forelse ($programs as $program)
                        @php
                            $namaProgram  = $program->program->nama ?? 'Program';
                            $namaLower    = strtolower($namaProgram);
                            $namaJenjang  = $program->jenjang->nama ?? null;
                            $isFeatured   = ($namaLower === 'reguler');
                            $fiturList    = $fiturProgram[$namaLower] ?? ['Kurikulum terstruktur', 'Pengajar berpengalaman', 'Modul lengkap'];
                        @endphp

                        <div class="utility-card program-card flex flex-col relative"
                            id="card-{{ Str::slug($namaProgram) }}"
                            @if($isFeatured) style="border-color: #0066cc; border-width: 2px;" @endif>

                            {{-- Badge Terpopuler (hanya Reguler) --}}
                            @if($isFeatured)
                                <div class="absolute -top-3 left-6">
                                    <span class="badge-blue">Terpopuler</span>
                                </div>
                            @endif

                            {{-- Nama Program --}}
                            <h3 class="t-tagline text-ink mb-1 {{ $isFeatured ? 'mt-2' : '' }}">
                                {{ $namaProgram }}
                            </h3>

                            {{-- Sub-judul: tampilkan jenjang jika ada --}}
                            @if($namaJenjang)
                                <p class="t-caption mb-6" style="color: #7a7a7a;">Jenjang: {{ $namaJenjang }}</p>
                            @else
                                <p class="t-caption mb-6" style="color: #7a7a7a;">Program bimbingan KAIFA</p>
                            @endif

                            {{-- Fitur / Checklist (dummy statis) --}}
                            <ul class="flex flex-col gap-3 flex-grow mb-8">
                                @foreach($fiturList as $fitur)
                                    <li class="check-item">
                                        <div class="check-dot">
                                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none">
                                                <path d="M1 4L3.5 6.5L9 1" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <span class="t-body text-ink">{{ $fitur }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Pricing — hanya SPP Bulanan dari DB --}}
                            <div class="hairline-top pt-6 mb-6">
                                <div class="flex justify-between items-baseline">
                                    <span class="t-caption" style="color: #7a7a7a;">SPP Bulanan</span>
                                    <span class="t-body-strong text-primary-blue">
                                        Rp {{ number_format($program->nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Tombol CTA --}}
                            <a href="https://wa.link/bmd9s5" target="_blank" rel="noopener noreferrer"
                                class="{{ $isFeatured ? 'btn-primary' : 'btn-secondary-pill' }} text-center"
                                id="cta-{{ Str::slug($namaProgram) }}">
                                Daftar Program Ini
                            </a>

                        </div>
                    @empty
                        {{-- Fallback jika tabel tarif_spp masih kosong --}}
                        <div class="col-span-3 text-center py-12">
                            <p class="t-body" style="color: #7a7a7a;">Data program belum tersedia. Silakan hubungi admin.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>
