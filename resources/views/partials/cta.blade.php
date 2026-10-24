<section class="kf-section pt-0">
    <div class="kf-container">
        <div class="relative overflow-hidden rounded-[2rem] bg-kf-blue px-6 py-12 sm:px-10 sm:py-14 lg:px-16 lg:py-16"
            data-reveal>
            {{-- Decoration --}}
            <div class="kf-blob -right-16 -top-20 h-64 w-64 bg-kf-yellow/25" aria-hidden="true"></div>
            <div class="kf-blob -bottom-24 -left-10 h-56 w-56 bg-white/10" aria-hidden="true"></div>

            <div class="relative grid gap-8 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-7">
                    <p class="kf-eyebrow kf-eyebrow--onDark">Mulai dari sini</p>
                    <h2 class="kf-h2 mt-4 text-white">Siap menemukan program yang paling pas?</h2>
                    <p class="mt-4 max-w-xl text-[1.0625rem] leading-relaxed text-white/85">
                        Ceritakan kebutuhan belajar anak Anda. Tim KAIFA akan membantu memilih program dan
                        jadwal yang sesuai — tanpa perlu mengisi formulir.
                    </p>
                </div>

                <div class="flex flex-col gap-3 lg:col-span-5 lg:items-end">
                    <a href="{{ $waRegister }}" target="_blank" rel="noopener noreferrer"
                        class="kf-btn kf-btn--onDark kf-btn--block sm:w-auto">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.23 8.23Z" />
                        </svg>
                        Daftar via WhatsApp
                    </a>

                    <a href="#program"
                        class="kf-btn kf-btn--block border-white/40 bg-transparent text-white hover:bg-white/10 sm:w-auto">
                        Lihat semua program
                    </a>

                    <p class="mt-1 text-center text-sm text-white/60 lg:text-right">
                        {{ $content['contact_hours'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
