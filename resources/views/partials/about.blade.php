@php
    $aboutPath = $photos['about'] ?? null;

    if ($aboutPath === null || ! file_exists(public_path($aboutPath))) {
        $aboutPath = 'images/keunggulan1.png';
    }
@endphp

<section id="tentang" class="kf-section relative">
    <div class="kf-container">
        <div class="grid items-center gap-10 lg:grid-cols-12 lg:gap-14">
            {{-- Image --}}
            <div class="relative lg:col-span-5">
                <div class="absolute -left-3 -top-3 h-24 w-24 rounded-2xl bg-kf-yellow sm:h-32 sm:w-32"
                    aria-hidden="true"></div>
                {{--
                    keunggulan1.png already has rounded corners and transparency baked
                    into the PNG. Wrapping it in another rounded card produced a visible
                    double frame, so the image keeps its own shape and the container adds
                    no border or background of its own.
                --}}
                <div class="relative">
                    <img src="{{ asset($aboutPath) }}" alt="Kegiatan belajar bersama pengajar KAIFA" width="725"
                        height="419" loading="lazy" decoding="async"
                        class="aspect-[725/419] w-full rounded-[1.75rem] object-cover">
                </div>
                <div class="absolute -bottom-5 right-3 rounded-xl bg-kf-ink px-4 py-2.5 sm:right-6">
                    <p class="font-display text-sm font-bold text-kf-cream">Teman Belajar</p>
                </div>
            </div>

            {{-- Copy --}}
            <div class="lg:col-span-7">
                <p class="kf-eyebrow">Tentang KAIFA</p>
                <h2 class="kf-h2 mt-4">Bimbingan belajar yang tumbuh bersama anak</h2>

                <p class="kf-lead mt-5">
                    {{ $content['about_description'] }}
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <article class="kf-card kf-card--hover">
                        <span class="kf-icon bg-kf-blue-soft text-kf-blue" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </span>
                        <h3 class="mt-4 font-display text-base font-bold text-kf-ink">Visi Kami</h3>
                        <p class="mt-2 text-sm leading-relaxed text-kf-ink-3">
                            {{ $content['about_vision'] }}
                        </p>
                    </article>

                    <article class="kf-card kf-card--hover">
                        <span class="kf-icon bg-kf-mint text-kf-ink" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 21V4m0 0h13l-2.5 4L17 12H4" />
                            </svg>
                        </span>
                        <h3 class="mt-4 font-display text-base font-bold text-kf-ink">Misi Kami</h3>
                        <p class="mt-2 text-sm leading-relaxed text-kf-ink-3">
                            {{ $content['about_mission'] }}
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>
