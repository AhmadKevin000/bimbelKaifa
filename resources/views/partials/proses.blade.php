@php
    /*
     * Replaces the previous illustrative "testimonial" section.
     *
     * The old section showed invented quotes attributed to generic roles. There
     * is nothing in this repository that verifies them, so they are gone. What is
     * left describes a learning-support flow in plain, non-numeric language —
     * no success rates, no student counts, no promised outcomes.
     *
     * The steps are editable from the admin panel (Konten Halaman Depan →
     * Perjalanan Belajar). Copy still needs a final check by the KAIFA owner.
     */
    $steps = array_values(array_filter(
        $content['process_steps'] ?? [],
        fn ($step) => is_array($step) && filled($step['title'] ?? null) && filled($step['description'] ?? null)
    ));
@endphp

@if (! empty($steps))
    <section id="proses" class="kf-section bg-kf-ink">
        <div class="kf-container">
            <div class="max-w-2xl">
                <p class="kf-eyebrow kf-eyebrow--onDark">Alur Pendampingan</p>
                <h2 class="kf-h2 mt-4 text-kf-cream">Perjalanan Belajar Bersama KAIFA</h2>
                <p class="mt-4 text-[1.0625rem] leading-relaxed text-white/70">
                    Tiga langkah sederhana yang menggambarkan bagaimana pendampingan belajar berjalan,
                    dari mengenali kebutuhan sampai meninjau perkembangan.
                </p>
            </div>

            <ol class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach ($steps as $index => $step)
                    <li class="flex h-full flex-col rounded-[1.25rem] border border-white/12 bg-white/[0.06] p-6"
                        data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-kf-yellow font-display text-base font-extrabold text-kf-ink"
                            aria-hidden="true">
                            {{ $index + 1 }}
                        </span>

                        <h3 class="mt-5 font-display text-[1.0625rem] font-bold leading-snug text-kf-cream">
                            <span class="sr-only">Langkah {{ $index + 1 }}: </span>{{ $step['title'] }}
                        </h3>

                        <p class="mt-2 flex-grow text-[0.95rem] leading-relaxed text-white/75">
                            {{ $step['description'] }}
                        </p>
                    </li>
                @endforeach
            </ol>

            <p class="mt-6 text-sm text-white/50">
                Alur ini bersifat umum; detail pelaksanaan dapat berbeda tergantung program dan jenjang.
            </p>
        </div>
    </section>
@endif
