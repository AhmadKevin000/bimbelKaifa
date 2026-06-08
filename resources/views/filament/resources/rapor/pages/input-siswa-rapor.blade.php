<x-filament-panels::page>
    <style>
        .rekap-card {
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            background-color: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-top: 1.5rem;
        }
        .dark .rekap-card {
            border-color: #374151;
            background-color: #111827;
        }
        .rekap-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .dark .rekap-header {
            border-color: #374151;
            background-color: #1f2937;
        }
        .rekap-header-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .rekap-header-text {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }
        .dark .rekap-header-text {
            color: #ffffff;
        }
        .rekap-header-sub {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.125rem;
        }
        .dark .rekap-header-sub {
            color: #94a3b8;
        }
        .rekap-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        @media (max-width: 640px) {
            .rekap-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        .rekap-item {
            padding: 1.25rem 1.5rem;
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }
        .rekap-item:last-child {
            border-right: none;
        }
        @media (max-width: 640px) {
            .rekap-item {
                border-right: none;
            }
            .rekap-item:nth-child(odd) {
                border-right: 1px solid #e2e8f0;
            }
            .rekap-item:nth-child(3), .rekap-item:nth-child(4) {
                border-top: 1px solid #e2e8f0;
            }
        }
        .dark .rekap-item {
            border-color: #374151;
        }
        .rekap-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .dark .rekap-label {
            color: #94a3b8;
        }
        .rekap-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.5rem;
            line-height: 1;
        }
        .dark .rekap-value {
            color: #ffffff;
        }
        .rekap-sublabel {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }
        .dark .rekap-sublabel {
            color: #64748b;
        }
    </style>

    <form wire:submit.prevent="save" class="fi-form space-y-6">
        {{ $this->form }}

        {{-- Rekap Nilai Card (Live Update via Alpine) --}}
        <div
            x-data="{
                get nilaiInputs() {
                    return Array.from(document.querySelectorAll('.nilai-input')).map(el => parseFloat(el.value) || 0);
                },
                totalMapel: {{ count($this->pengajaranList) }},
                total: 0,
                terisi: 0,
                rataRata: 0,
                predikat: '-',
                predikatColor: 'gray',
                calculate() {
                    const inputs = this.nilaiInputs;
                    const filled = inputs.filter(v => v > 0);
                    this.terisi = filled.length;
                    this.total = filled.reduce((a, b) => a + b, 0);
                    this.rataRata = filled.length > 0 ? (this.total / filled.length).toFixed(1) : '0';

                    const avg = parseFloat(this.rataRata);
                    if (avg >= 90) { this.predikat = 'A'; this.predikatColor = '#16a34a'; }
                    else if (avg >= 80) { this.predikat = 'B'; this.predikatColor = '#2563eb'; }
                    else if (avg >= 70) { this.predikat = 'C'; this.predikatColor = '#d97706'; }
                    else { this.predikat = 'D'; this.predikatColor = '#dc2626'; }
                }
            }"
            x-init="
                calculate();
                document.addEventListener('input', (e) => {
                    if (e.target.classList.contains('nilai-input')) calculate();
                });
            "
            class="rekap-card"
        >
            {{-- Header --}}
            <div class="rekap-header">
                <div class="rekap-header-title">
                    <x-heroicon-o-calculator class="text-primary-500" style="width: 20px; height: 20px; flex-shrink: 0;" />
                    <h3 class="rekap-header-text">Rekap Nilai</h3>
                </div>
                <p class="rekap-header-sub">Kalkulasi otomatis berdasarkan nilai yang diinput</p>
            </div>

            {{-- Stats Grid --}}
            <div class="rekap-grid">
                {{-- Jumlah Mapel --}}
                <div class="rekap-item">
                    <p class="rekap-label">Mata Pelajaran</p>
                    <p class="rekap-value">
                        <span x-text="terisi"></span><span style="font-size: 0.875rem; font-weight: normal; color: #9ca3af;">/<span x-text="totalMapel"></span></span>
                    </p>
                    <p class="rekap-sublabel">Terisi</p>
                </div>

                {{-- Total Nilai --}}
                <div class="rekap-item">
                    <p class="rekap-label">Total Nilai</p>
                    <p class="rekap-value" x-text="total"></p>
                    <p class="rekap-sublabel">Poin</p>
                </div>

                {{-- Rata-rata --}}
                <div class="rekap-item">
                    <p class="rekap-label">Rata-rata</p>
                    <p class="rekap-value" x-text="rataRata"></p>
                    <p class="rekap-sublabel">dari 100</p>
                </div>

                {{-- Predikat --}}
                <div class="rekap-item">
                    <p class="rekap-label">Predikat</p>
                    <p
                        class="rekap-value"
                        style="font-weight: 900; font-size: 2rem;"
                        :style="{ color: predikatColor }"
                        x-text="predikat"
                    ></p>
                    <p class="rekap-sublabel">
                        <span x-show="predikat === 'A'">Sangat Baik</span>
                        <span x-show="predikat === 'B'">Baik</span>
                        <span x-show="predikat === 'C'">Cukup</span>
                        <span x-show="predikat === 'D'">Kurang</span>
                        <span x-show="predikat === '-'">-</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="fi-form-actions mt-6 flex flex-wrap items-center gap-3">
            @foreach($this->getFormActions() as $action)
                {{ $action }}
            @endforeach
        </div>
    </form>
</x-filament-panels::page>
