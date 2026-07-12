<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Custom Styles — mengikuti gaya Bank Soal --}}
        <style>
            .rapor-header-card {
                background: linear-gradient(135deg, #4364F7 0%, #6FB1FC 100%);
                border-radius: 1rem;
                padding: 1.5rem 2rem;
                color: #fff;
                box-shadow: 0 8px 30px -4px rgba(67, 100, 247, 0.3);
                position: relative;
                overflow: hidden;
            }
            .rapor-header-card::before {
                content: '';
                position: absolute;
                top: -30%; right: -10%;
                width: 200px; height: 200px;
                border-radius: 50%;
                background: rgba(255,255,255,0.08);
            }
            .rapor-header-inner {
                position: relative;
                z-index: 1;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
            }
            .rapor-tab {
                padding: 0.375rem 0.875rem;
                font-size: 0.875rem;
                font-weight: 600;
                border-radius: 0.5rem;
                transition: all 0.2s;
                cursor: pointer;
                border: none;
            }
            .rapor-tab-active {
                background-color: #4364F7;
                color: #ffffff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.15);
            }
            .rapor-tab-inactive {
                background-color: #f3f4f6;
                color: #4b5563;
            }
            .rapor-tab-inactive:hover {
                background-color: #e5e7eb;
            }
            .dark .rapor-tab-inactive {
                background-color: #1f2937;
                color: #d1d5db;
            }
            .dark .rapor-tab-inactive:hover {
                background-color: #374151;
            }
        </style>

        {{-- ── HEADER CARD (Gradient biru, gaya Bank Soal) ── --}}
        <div class="rapor-header-card">
            <div class="rapor-header-inner">
                <div>
                    <p class="text-sm text-white/80 mb-0.5">Halaman Rapor Kelas</p>
                    <h2 class="text-2xl font-extrabold text-white">{{ $this->record->nama_kelas }}</h2>
                    <p class="text-xs text-white/70 mt-1">
                        {{ $this->record->siswa()->count() }} siswa terdaftar
                        &mdash; {{ $this->record->pengajaran()->count() }} mata pelajaran
                    </p>
                </div>

                {{-- ── Semester Tabs ── --}}
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs text-white/70 font-semibold uppercase tracking-wider">Semester:</span>
                    <button
                        wire:click="setSemester('1')"
                        class="rapor-tab {{ $semester === '1' ? 'rapor-tab-active' : 'bg-white/20 text-white hover:bg-white/30' }}"
                    >
                        Semester 1 (Ganjil)
                    </button>
                    <button
                        wire:click="setSemester('2')"
                        class="rapor-tab {{ $semester === '2' ? 'rapor-tab-active' : 'bg-white/20 text-white hover:bg-white/30' }}"
                    >
                        Semester 2 (Genap)
                    </button>
                </div>
            </div>
        </div>

        {{-- ── TABEL SISWA (gaya card Bank Soal) ── --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            {{-- Table Header Bar --}}
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Siswa</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Semester {{ $semester === '1' ? '1 (Ganjil)' : '2 (Genap)' }} — Pilih siswa untuk input nilai rapor
                    </p>
                </div>
            </div>

            {{-- Filament Table --}}
            <div>
                {{ $this->table }}
            </div>
        </div>

    </div>
</x-filament-panels::page>
