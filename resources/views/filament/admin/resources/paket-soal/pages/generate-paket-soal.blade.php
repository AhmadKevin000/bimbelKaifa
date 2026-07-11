<x-filament-panels::page>
    <div class="space-y-6">
        <style>
            .wizard-step-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: relative;
                max-width: 600px;
                margin: 0 auto 2rem;
            }
            .wizard-step-line {
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 2px;
                background: #e2e8f0;
                z-index: 1;
                transform: translateY(-50%);
            }
            .dark .wizard-step-line { background: #334155; }
            .wizard-step-line-active {
                position: absolute;
                top: 50%;
                left: 0;
                height: 2px;
                background: #4364F7;
                z-index: 2;
                transform: translateY(-50%);
                transition: width 0.3s ease;
            }
            .wizard-step-circle {
                width: 2.5rem;
                height: 2.5rem;
                border-radius: 50%;
                background: #fff;
                border: 2px solid #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 0.9rem;
                z-index: 3;
                position: relative;
                color: #64748b;
                transition: all 0.3s ease;
            }
            .dark .wizard-step-circle {
                background: #1e293b;
                border-color: #334155;
                color: #94a3b8;
            }
            .wizard-step-circle.active {
                border-color: #4364F7;
                color: #4364F7;
                box-shadow: 0 0 0 4px rgba(67, 100, 247, 0.15);
            }
            .wizard-step-circle.completed {
                background: #4364F7;
                border-color: #4364F7;
                color: #fff;
            }
            
            /* Custom Selectable Cards */
            .select-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem;
            }
            @media (max-width: 1024px) {
                .select-grid { grid-template-columns: repeat(2, 1fr); }
            }
            @media (max-width: 640px) {
                .select-grid { grid-template-columns: 1fr; }
            }
            .select-card {
                border-radius: 1rem;
                padding: 1.25rem;
                border: 2px solid #f1f5f9;
                background: #fff;
                transition: all 0.2s ease;
                cursor: pointer;
                position: relative;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                min-height: 100px;
            }
            .dark .select-card {
                background: #1e293b;
                border-color: #334155;
            }
            .select-card:hover {
                transform: translateY(-2px);
                border-color: #cbd5e1;
            }
            .dark .select-card:hover {
                border-color: #475569;
            }
            .select-card.selected {
                border-color: #4364F7;
                background: rgba(67, 100, 247, 0.03);
            }
            .dark .select-card.selected {
                border-color: #6fb1fc;
                background: rgba(111, 177, 252, 0.04);
            }
            
            /* Method selection cards */
            .method-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            @media (max-width: 640px) {
                .method-grid { grid-template-columns: 1fr; }
            }
            .method-card {
                border-radius: 1rem;
                padding: 1.75rem;
                border: 2px solid #f1f5f9;
                background: #fff;
                text-align: center;
                cursor: pointer;
                transition: all 0.25s ease;
            }
            .dark .method-card {
                background: #1e293b;
                border-color: #334155;
            }
            .method-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05);
            }
            .method-card.selected {
                border-color: #4364F7;
                background: rgba(67, 100, 247, 0.02);
                box-shadow: 0 10px 25px -5px rgba(67, 100, 247, 0.1);
            }
            .dark .method-card.selected {
                border-color: #6fb1fc;
                background: rgba(111, 177, 252, 0.03);
            }
        </style>

        {{-- WIZARD STEPS PROGRESS BAR --}}
        @if(empty($paketDibuatList))
            <div class="wizard-step-header">
                <div class="wizard-step-line"></div>
                <div class="wizard-step-line-active" style="width: {{ (($step - 1) / 2) * 100 }}%"></div>
                
                <div class="wizard-step-circle {{ $step === 1 ? 'active' : ($step > 1 ? 'completed' : '') }}">
                    @if($step > 1) ✓ @else 1 @endif
                </div>
                <div class="wizard-step-circle {{ $step === 2 ? 'active' : ($step > 2 ? 'completed' : '') }}">
                    @if($step > 2) ✓ @else 2 @endif
                </div>
                <div class="wizard-step-circle {{ $step === 3 ? 'active' : '' }}">
                    3
                </div>
            </div>
        @endif

        {{-- POST GENERATION SUCCESS PANEL --}}
        @if(!empty($paketDibuatList))
            <div class="space-y-6">
                <div class="bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-green-500 text-white rounded-lg">
                            <x-heroicon-o-check-circle class="w-6 h-6" />
                        </div>
                        <div class="flex-1 space-y-1">
                            <h3 class="font-extrabold text-green-900 dark:text-green-300 text-lg">Paket Soal Berhasil Dibuat!</h3>
                            <p class="text-sm text-green-700/90 dark:text-green-400/90">
                                Koleksi paket soal Anda telah berhasil disimpan ke database. Silakan cetak Lembar Soal atau Kunci Jawaban di bawah ini.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Cards per generated packet --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($paketDibuatList as $pkt)
                        <div class="bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-xl p-5 shadow-sm space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary px-2.5 py-1 rounded-full uppercase tracking-wider">PAKET SOAL</span>
                                <span class="text-xs text-gray-400 font-mono">ID: #{{ $pkt['id'] }}</span>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base leading-tight">{{ $pkt['judul'] }}</h4>
                            <div class="grid grid-cols-2 gap-2 pt-2">
                                <a href="{{ route('bank-soal.paket.pdf', $pkt['id']) }}" target="_blank"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-primary hover:opacity-90 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                                    <x-heroicon-m-printer class="w-3.5 h-3.5" /> Cetak Soal (PDF)
                                </a>
                                <a href="{{ route('bank-soal.paket.kunci', $pkt['id']) }}" target="_blank"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition shadow-sm">
                                    <x-heroicon-m-key class="w-3.5 h-3.5" /> Cetak Kunci (PDF)
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-center pt-4">
                    <button wire:click="resetWizard"
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-sm font-semibold rounded-lg transition">
                        Buat Paket Lagi
                    </button>
                </div>
            </div>
        @else

            {{-- STEP 1: PILIH JENJANG & MAPEL --}}
            @if($step === 1)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Langkah 1: Pilih Jenjang Pendidikan</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Pilih satu jenjang pendidikan untuk paket soal yang akan dicetak.
                        </p>
                    </div>

                    {{-- Jenjang Select Cards --}}
                    <div class="select-grid" x-data="{ selectedIds: @entangle('selectedJenjangIds') }">
                        @foreach($this->jenjangOptions as $id => $nama)
                            <div class="select-card"
                                 :class="selectedIds.includes({{ $id }}) ? 'selected' : ''"
                                 @click="
                                     if (selectedIds.includes({{ $id }})) {
                                         selectedIds = [];
                                     } else {
                                         selectedIds = [{{ $id }}];
                                     }
                                 ">
                                <div class="flex items-center justify-between">
                                    <span class="font-extrabold text-sm" :class="selectedIds.includes({{ $id }}) ? 'text-primary dark:text-primary' : 'text-gray-700 dark:text-gray-300'">{{ $nama }}</span>
                                    <div class="w-4 h-4 rounded border flex items-center justify-center transition" :class="selectedIds.includes({{ $id }}) ? 'border-primary bg-primary text-white' : 'border-gray-300 dark:border-gray-600'">
                                        <span x-show="selectedIds.includes({{ $id }})">✓</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('selectedJenjangIds') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                    {{-- Dropdown Mapel & Kelas (Hanya jika 1 jenjang terpilih) --}}
                    @if(count($selectedJenjangIds) === 1)
                        <div class="border-t border-gray-100 dark:border-gray-800 pt-5 grid grid-cols-1 md:grid-cols-2 gap-4 max-w-xl">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Mata Pelajaran (Opsional)</label>
                                <select wire:model="mapel_id"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($this->mapelOptions as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Kelas (Opsional)</label>
                                <select wire:model="kelas_id"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm shadow-sm focus:ring-primary focus:border-primary">
                                    <option value="">Semua Kelas</option>
                                    @foreach($this->kelasOptions as $id => $nama)
                                        <option value="{{ $id }}">{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-end pt-2 border-t border-gray-150 dark:border-gray-800">
                        <x-filament::button wire:click="nextStep" color="primary" icon="heroicon-o-arrow-right" icon-position="after">
                            Lanjutkan
                        </x-filament::button>
                    </div>
                </div>
            @endif

            {{-- STEP 2: METODE & PARAMETER --}}
            @if($step === 2)
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-6">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Langkah 2: Pilih Metode Pembuatan</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pilih bagaimana soal akan dikumpulkan ke dalam paket.</p>
                        </div>

                        {{-- Mode Selection Cards (Disabled if Multi-Jenjang) --}}
                        <div class="method-grid">
                            <div class="method-card {{ $metode === 'acak' ? 'selected' : '' }}" 
                                 wire:click="$set('metode', 'acak')">
                                <div class="text-2xl mb-2">🎲</div>
                                <h4 class="font-bold text-sm text-gray-800 dark:text-white">Generate Acak</h4>
                                <p class="text-xs text-gray-400 mt-1">Soal dipilih secara acak oleh mesin berdasarkan kuota dan tipe soal.</p>
                            </div>

                            <button class="method-card {{ $metode === 'manual' ? 'selected' : '' }} {{ count($selectedJenjangIds) > 1 ? 'opacity-40 cursor-not-allowed' : '' }}"
                                    @disabled(count($selectedJenjangIds) > 1)
                                    wire:click="$set('metode', 'manual')">
                                <div class="text-2xl mb-2">✅</div>
                                <h4 class="font-bold text-sm text-gray-800 dark:text-white">Pilih Manual</h4>
                                <p class="text-xs text-gray-400 mt-1">Pilih sendiri satu-persatu soal dari daftar checklist.</p>
                            </button>
                        </div>

                        {{-- Sub Form: Acak --}}
                        @if($metode === 'acak')
                            <div class="space-y-4 border-t border-gray-100 dark:border-gray-800 pt-5">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Kelas (Target)</label>
                                        <select wire:model.live="kelas_id"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm shadow-sm focus:ring-primary focus:border-primary">
                                            <option value="">Semua Kelas</option>
                                            @foreach($this->kelasOptions as $id => $nama)
                                                <option value="{{ $id }}">{{ $nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Tipe Soal</label>
                                        <select wire:model.live="tipe_soal"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm shadow-sm focus:ring-primary focus:border-primary">
                                            <option value="">Campur (PG + Esai)</option>
                                            <option value="pilihan_ganda">Pilihan Ganda Saja</option>
                                            <option value="esai">Esai Saja</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Jumlah Soal</label>
                                        <div class="flex items-center gap-3">
                                            <input type="number" wire:model="jumlah_soal" min="1" max="200"
                                                   class="w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm shadow-sm focus:ring-primary focus:border-primary" />
                                            <span class="text-xs font-semibold px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-500 rounded-full whitespace-nowrap">
                                                Total: {{ $this->tersediaSoal }}
                                            </span>
                                        </div>
                                        @error('jumlah_soal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Sub Form: Manual Checklist --}}
                            <div class="space-y-4 border-t border-gray-100 dark:border-gray-800 pt-5">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300">Checklist Soal Terpilih</h4>
                                    <span class="text-xs font-bold px-2.5 py-1 bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary rounded-full">
                                        {{ count($selectedSoalIds) }} Soal Terpilih
                                    </span>
                                </div>
                                @error('selectedSoalIds') <p class="text-xs text-red-500 mb-2">{{ $message }}</p> @enderror

                                <div class="max-h-[400px] overflow-y-auto border border-gray-250 dark:border-gray-800 rounded-lg divide-y divide-gray-150 dark:divide-gray-800">
                                    @forelse($this->soalTersediaList as $soal)
                                        @php $isChecked = in_array($soal['id'], $selectedSoalIds); @endphp
                                        <label class="flex items-start gap-3 p-4 cursor-pointer transition hover:bg-gray-50/50 dark:hover:bg-gray-800/40 {{ $isChecked ? 'bg-primary/5 dark:bg-primary/5' : '' }}">
                                            <input type="checkbox" 
                                                   value="{{ $soal['id'] }}" 
                                                   wire:model.live="selectedSoalIds"
                                                   class="text-primary focus:ring-primary rounded border-gray-300 mt-1" />
                                            <div class="flex-1 space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $soal['tipe_soal'] === 'pilihan_ganda' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30' }}">
                                                        {{ $soal['tipe_soal'] === 'pilihan_ganda' ? 'Pilihan Ganda' : 'Esai' }}
                                                    </span>
                                                    <span class="text-[10px] text-gray-500">{{ $soal['mapel_nama'] }} • {{ $soal['jenjang_nama'] }}</span>
                                                </div>
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 leading-snug line-clamp-2">{{ $soal['pertanyaan'] }}</p>
                                                @if($soal['gambar_soal'])
                                                    <div class="pt-1">
                                                        <img src="{{ asset('storage/' . $soal['gambar_soal']) }}" class="h-10 w-auto rounded border" />
                                                    </div>
                                                @endif
                                            </div>
                                        </label>
                                    @empty
                                        <p class="p-6 text-center text-sm text-gray-500">Tidak ada soal yang tersedia.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        {{-- Judul Paket input --}}
                        <div class="border-t border-gray-100 dark:border-gray-800 pt-5 space-y-1 max-w-lg">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Judul Paket Soal</label>
                            <input type="text" 
                                   wire:model="judul"
                                   placeholder="Contoh: Ujian Akhir Semester Ganjil"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm shadow-sm focus:ring-primary focus:border-primary" />
                            @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Navigation Actions --}}
                        <div class="flex justify-between items-center pt-4 border-t border-gray-150 dark:border-gray-800">
                            <x-filament::button wire:click="prevStep" color="gray" icon="heroicon-o-arrow-left">
                                Kembali
                            </x-filament::button>
                            <x-filament::button wire:click="nextStep" color="primary" icon="heroicon-o-eye" icon-position="after">
                                Preview Paket
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STEP 3: PREVIEW & CONFIRM --}}
            @if($step === 3)
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-6">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Langkah 3: Preview Final Paket</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tinjau susunan soal sebelum paket disimpan ke database.</p>
                        </div>

                        {{-- Render Preview Per Paket --}}
                        <div class="space-y-8">
                            @foreach($tempPreviewSoals as $jId => $data)
                                <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm">
                                    <div class="bg-gray-50 dark:bg-gray-800 px-5 py-4 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
                                        <div>
                                            <span class="text-[10px] font-extrabold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $data['jenjang_nama'] }}</span>
                                            <h4 class="font-bold text-gray-800 dark:text-gray-200 mt-1 text-sm">{{ $data['judul'] }}</h4>
                                        </div>
                                        <span class="text-xs text-gray-500 font-bold font-mono">{{ count($data['soals']) }} Soal</span>
                                    </div>

                                    <div class="p-6 divide-y divide-gray-100 dark:divide-gray-800 space-y-6">
                                        @foreach($data['soals'] as $num => $soal)
                                            <div class="pt-6 first:pt-0 space-y-3">
                                                <div class="flex items-start gap-2">
                                                    <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $num + 1 }}.</span>
                                                    <div class="space-y-3 flex-1">
                                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 leading-relaxed">{!! nl2br(e($soal['pertanyaan'])) !!}</p>
                                                        
                                                        @if($soal['gambar_soal'])
                                                            <div>
                                                                <img src="{{ asset('storage/' . $soal['gambar_soal']) }}" class="max-h-40 rounded border object-contain" />
                                                            </div>
                                                        @endif

                                                        @if($soal['tipe_soal'] === 'pilihan_ganda')
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-2">
                                                                @foreach($soal['opsi'] as $o)
                                                                    <div class="flex items-start gap-2 text-xs">
                                                                        <span class="w-5 h-5 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center font-bold text-gray-500">{{ $o['label'] }}</span>
                                                                        <div class="flex-1">
                                                                            <p class="text-gray-700 dark:text-gray-300 pt-0.5">{{ $o['teks'] }}</p>
                                                                            @if($o['gambar'])
                                                                                <img src="{{ asset('storage/' . $o['gambar']) }}" class="h-16 w-auto mt-1 rounded border object-cover" />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="space-y-1 pl-2">
                                                                <div class="border-b border-dashed border-gray-300 dark:border-gray-600 h-8 max-w-lg"></div>
                                                                <div class="border-b border-dashed border-gray-300 dark:border-gray-600 h-8 max-w-lg"></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Wizard Actions --}}
                        <div class="flex justify-between items-center pt-4 border-t border-gray-150 dark:border-gray-800">
                            <x-filament::button wire:click="prevStep" color="gray" icon="heroicon-o-arrow-left">
                                Kembali
                            </x-filament::button>
                            <x-filament::button wire:click="generate" wire:target="generate" wire:loading.attr="disabled" color="success" icon="heroicon-o-cloud-arrow-up" icon-position="after">
                                Simpan & Buat Paket
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            @endif

        @endif
    </div>
</x-filament-panels::page>
