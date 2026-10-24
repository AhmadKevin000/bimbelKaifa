@php
    /*
     * FAQ items are editable from the admin panel (Konten Halaman Depan → FAQ).
     * LandingSetting::content() always returns a non-empty list, falling back to
     * the same copy that shipped before the CMS existed.
     */
    $faqs = array_values(array_filter(
        $content['faqs'] ?? [],
        fn ($faq) => is_array($faq) && filled($faq['question'] ?? null) && filled($faq['answer'] ?? null)
    ));
@endphp

<section id="faq" class="kf-section border-t border-kf-line">
    <div class="kf-container">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
            <div class="lg:col-span-4">
                <p class="kf-eyebrow">FAQ</p>
                <h2 class="kf-h2 mt-4">Pertanyaan yang sering ditanyakan</h2>
                <p class="kf-lead mt-4">
                    Belum menemukan jawabannya? Tanyakan langsung ke admin KAIFA.
                </p>
                <a href="{{ $waConsult }}" target="_blank" rel="noopener noreferrer"
                    class="kf-btn kf-btn--quiet mt-6">
                    Tanya admin
                </a>
            </div>

            <div class="lg:col-span-8">
                <div class="flex flex-col gap-3">
                    @foreach ($faqs as $faq)
                        <details class="kf-faq" @if ($loop->first) open @endif>
                            <summary>
                                <span>{{ $faq['question'] }}</span>
                                <span class="kf-faq__icon" aria-hidden="true">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                </span>
                            </summary>
                            <div class="kf-faq__body">
                                <p>{{ $faq['answer'] }}</p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
