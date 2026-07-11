<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Custom Styles matching dashboard widgets --}}
        <style>
            .bs-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem;
            }
            @media (max-width: 1024px) {
                .bs-grid { grid-template-columns: repeat(2, 1fr); }
            }
            @media (max-width: 640px) {
                .bs-grid { grid-template-columns: 1fr; }
            }
            .bs-card {
                border-radius: 1rem;
                padding: 1.25rem 1.5rem;
                color: #fff;
                position: relative;
                overflow: hidden;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                cursor: pointer;
                min-height: 120px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .bs-card:hover {
                transform: translateY(-3px);
            }
            .bs-card::before {
                content: '';
                position: absolute;
                top: -20%;
                right: -15%;
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: rgba(255,255,255,0.1);
            }
            .bs-card::after {
                content: '';
                position: absolute;
                bottom: -30%;
                right: 5%;
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: rgba(255,255,255,0.06);
            }
            .bs-card-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                position: relative;
                z-index: 1;
            }
            .bs-card-badge {
                font-size: 0.65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                background: rgba(255,255,255,0.22);
                padding: 0.15rem 0.5rem;
                border-radius: 999px;
                backdrop-filter: blur(4px);
            }
            .bs-card-bottom {
                position: relative;
                z-index: 1;
                margin-top: 0.75rem;
            }
            .bs-card-label {
                font-size: 0.78rem;
                font-weight: 500;
                color: rgba(255,255,255,0.85);
                margin: 0;
            }
            .bs-card-value {
                font-size: 1.5rem;
                font-weight: 800;
                margin: 0.15rem 0 0;
                line-height: 1.2;
            }
            
            /* Glassmorphism card for state header */
            .bs-header-card {
                background: linear-gradient(135deg, #4364F7 0%, #6FB1FC 100%);
                border-radius: 1rem;
                padding: 1.5rem 2rem;
                color: #fff;
                box-shadow: 0 8px 30px -4px rgba(67, 100, 247, 0.3);
                position: relative;
                overflow: hidden;
            }
            .bs-header-card::before {
                content: '';
                position: absolute;
                top: -30%;
                right: -10%;
                width: 200px;
                height: 200px;
                border-radius: 50%;
                background: rgba(255,255,255,0.08);
            }
            .bs-header-card-inner {
                position: relative;
                z-index: 1;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            /* Modal overlay */
            .bs-modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 50;
            }
            .bs-modal-content {
                background: white;
                border-radius: 1rem;
                max-width: 900px;
                width: 100%;
                max-height: 90vh;
                overflow-y: auto;
                box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            }
            .dark .bs-modal-content {
                background: #1f2937;
                color: white;
            }
            .bs-tab {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                font-weight: 600;
                border-radius: 0.5rem;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 0.375rem;
            }
            .bs-tab-active {
                background-color: #4364F7 !important;
                color: #ffffff !important;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .bs-tab-inactive {
                background-color: #f3f4f6;
                color: #4b5563;
            }
            .bs-tab-inactive:hover {
                background-color: #e5e7eb;
            }
            .dark .bs-tab-inactive {
                background-color: #1f2937;
                color: #d1d5db;
            }
            .dark .bs-tab-inactive:hover {
                background-color: #374151;
            }
            
            .bs-badge-active {
                background-color: rgba(255, 255, 255, 0.25) !important;
                color: #ffffff !important;
            }
            .bs-badge-inactive {
                background-color: #e5e7eb;
                color: #4b5563;
            }
            .dark .bs-badge-inactive {
                background-color: #374151;
                color: #9ca3af;
            }
        </style>

        @if(!$selectedKelasId)
            {{-- STATE A: GRID JENJANG & TABEL KELAS --}}
            <div class="space-y-6">
                {{-- Jenjang Grid Cards --}}
                <div class="bs-grid" wire:loading.class="opacity-50">
                    @foreach($this->jenjangGrid as $idx => $j)
                        <div class="bs-card cursor-pointer transition relative overflow-hidden group border-2 {{ $filterJenjangId === $j['id'] ? 'border-primary ring-2 ring-primary/20 shadow-lg' : 'border-transparent' }}" 
                             wire:click="toggleJenjangFilter({{ $j['id'] }})"
                             style="background: {{ $this->cardGradient($idx) }}; box-shadow: 0 8px 25px -4px {{ $this->cardShadow($idx) }};">
                            
                            @if($filterJenjangId === $j['id'])
                                <div class="absolute top-2 right-2 bg-white text-primary rounded-full p-1 shadow-md z-10">
                                    <x-heroicon-m-check class="w-4 h-4" />
                                </div>
                            @endif

                            <div class="bs-card-top">
                                <span class="bs-card-value text-white">{{ $j['nama'] }}</span>
                                <span class="bs-card-badge bg-white/20 text-white backdrop-blur-sm">Jenjang</span>
                            </div>
                            <div class="bs-card-bottom text-white">
                                <p class="bs-card-label text-white/80">{{ $j['mapel_punya_soal'] }} / {{ $j['total_mapel'] }} Mapel terisi</p>
                                <p class="bs-card-value text-white">{{ $j['total_soal'] }} Soal</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Table Kelas --}}
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/30">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Kelas Terdaftar</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                @if($filterJenjangId)
                                    Menampilkan kelas untuk jenjang <strong>{{ collect($this->jenjangGrid)->firstWhere('id', $filterJenjangId)['nama'] ?? '' }}</strong>.
                                @else
                                    Menampilkan semua kelas yang terdaftar di sistem. Pilih jenjang di atas untuk menyaring.
                                @endif
                            </p>
                        </div>
                        @if($filterJenjangId)
                            <button wire:click="$set('filterJenjangId', null)" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg transition">
                                <x-heroicon-o-x-mark class="w-3.5 h-3.5" /> Hapus Filter
                            </button>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-800 text-gray-500 font-semibold border-b border-gray-100 dark:border-gray-700">
                                    <th class="px-6 py-4">Nama Kelas</th>
                                    <th class="px-6 py-4">Jenjang</th>
                                    <th class="px-6 py-4">Jumlah Mapel</th>
                                    <th class="px-6 py-4">Total Soal</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($this->kelasTable as $k)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition">
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            {{ $k['nama'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                                {{ $k['jenjang_nama'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">
                                            {{ $k['mapel_punya_soal'] }} / {{ $k['total_mapel'] }} Mapel terisi
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">
                                            {{ $k['total_soal'] }} Soal
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button wire:click="selectKelas({{ $k['id'] }}, '{{ $k['nama'] }}')"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-primary/10 hover:bg-primary/20 text-primary dark:bg-primary/20 dark:hover:bg-primary/30 dark:text-primary-fixed rounded-lg transition shadow-sm">
                                                Pilih Kelas <x-heroicon-o-chevron-right class="w-3.5 h-3.5" />
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada kelas yang terdaftar untuk filter jenjang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- STATE B: DETAIL SOAL KELAS --}}
            <div class="space-y-6">
                {{-- Header Card (Gradient) --}}
                <div class="bs-header-card">
                    <div class="bs-header-card-inner">
                        <div>
                            <p class="text-sm text-white/80">Koleksi Bank Soal untuk kelas</p>
                            <h2 class="text-2xl font-extrabold text-white">{{ $selectedKelasNama }}</h2>
                            <p class="text-xs text-white/70 mt-1">Total: {{ $this->totalSoalKelas }} soal terdaftar di database.</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ $this->getTemplateUrl() }}" target="_blank"
                               class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white text-xs font-semibold px-4 py-2 rounded-lg transition backdrop-blur-sm border border-white/10">
                                <x-heroicon-o-arrow-down-tray class="w-4 h-4" /> Template Excel
                            </a>
                            <a href="{{ $this->getImportUrl() }}"
                               class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-xs font-bold px-4 py-2 rounded-lg transition shadow"
                               style="color: #4364F7;">
                                <x-heroicon-o-arrow-up-tray class="w-4 h-4" style="color: #4364F7;" /> Import Soal
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Mapel Selection Tabs --}}
                <div class="flex flex-wrap items-center gap-2 bg-white dark:bg-gray-900 rounded-xl p-3 border border-gray-100 dark:border-gray-800 shadow-sm">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-2">Mata Pelajaran:</span>
                    @forelse($this->mapelsInKelas as $m)
                        <button wire:click="selectMapel({{ $m['id'] }})"
                                class="bs-tab {{ $selectedMapelId === $m['id'] ? 'bs-tab-active' : 'bs-tab-inactive' }}">
                            {{ $m['nama'] }}
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $selectedMapelId === $m['id'] ? 'bs-badge-active' : 'bs-badge-inactive' }}">
                                {{ $m['soal_count'] }}
                            </span>
                        </button>
                    @empty
                        <span class="text-sm text-gray-500 italic px-2">Belum ada mata pelajaran terdaftar pada kelas ini.</span>
                    @endforelse
                </div>

                @if(!$selectedMapelId)
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-100 dark:border-gray-800 text-center">
                        <x-heroicon-o-exclamation-circle class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                        <h3 class="text-base font-bold text-gray-700 dark:text-gray-300">Belum ada Mata Pelajaran</h3>
                        <p class="text-sm text-gray-500 mt-1">Silakan daftarkan mata pelajaran untuk kelas ini terlebih dahulu.</p>
                    </div>
                @else
                    {{-- Filter & Action Bar --}}
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-100 dark:border-gray-800 shadow-sm flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                        <div class="flex flex-wrap items-center gap-3 flex-1">
                            {{-- Search Input --}}
                            <div class="relative w-full max-w-xs">
                                <x-heroicon-o-magnifying-glass class="w-4 h-4 absolute left-3 top-3 text-gray-400" />
                                <input type="text" 
                                       wire:model.live.debounce.300ms="search" 
                                       placeholder="Cari pertanyaan..." 
                                       class="pl-9 pr-4 py-2 text-sm w-full rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary focus:border-primary" />
                            </div>

                            @if(count($selectedSoalBulk) > 0)
                                <button wire:click="confirmBulkDelete" 
                                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold bg-red-600 hover:bg-red-700 text-white rounded-lg transition shadow animate-pulse">
                                    <x-heroicon-o-trash class="w-4 h-4" /> Hapus Terpilih ({{ count($selectedSoalBulk) }})
                                </button>
                            @endif
                        </div>

                        <button wire:click="openAddModal" 
                                class="inline-flex items-center justify-center gap-2 bg-primary hover:opacity-90 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition shadow">
                            <x-heroicon-o-plus class="w-4 h-4" /> Tambah Soal
                        </button>
                    </div>

                    {{-- Table/List Soal --}}
                    @if(empty($this->soalPaginator) || $this->soalPaginator->isEmpty())
                        <div class="bg-white dark:bg-gray-900 rounded-xl p-10 border border-gray-100 dark:border-gray-800 text-center shadow-sm">
                            <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-dashed border-gray-200 dark:border-gray-700">
                                <x-heroicon-o-document-text class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="text-base font-bold text-gray-700 dark:text-gray-300">Belum ada soal yang tersedia</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-xs mx-auto">
                                Belum ada soal yang diunggah atau dibuat untuk mata pelajaran ini pada kelas ini.
                            </p>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden" wire:loading.class="opacity-60">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-800 text-gray-500 font-semibold border-b border-gray-100 dark:border-gray-700">
                                            <th class="px-6 py-4 w-12 text-center">
                                                <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-primary focus:ring-primary" />
                                            </th>
                                            <th class="px-6 py-4">ID</th>
                                            <th class="px-6 py-4">Mata Pelajaran</th>
                                            <th class="px-6 py-4">Tipe Soal</th>
                                            <th class="px-6 py-4">Pertanyaan</th>
                                            <th class="px-6 py-4 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                        @foreach($this->soalPaginator as $soal)
                                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition">
                                                <td class="px-6 py-4 text-center">
                                                    <input type="checkbox" wire:model.live="selectedSoalBulk" value="{{ $soal->id }}" class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-primary focus:ring-primary" />
                                                </td>
                                                <td class="px-6 py-4 text-gray-500">#{{ $soal->id }}</td>
                                                <td class="px-6 py-4 font-medium">{{ $soal->mapel->nama }}</td>
                                                <td class="px-6 py-4">
                                                    @if($soal->tipe_soal === 'pilihan_ganda')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">Pilihan Ganda</span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Esai</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 max-w-md">
                                                    <p class="line-clamp-2">{{ $soal->pertanyaan }}</p>
                                                    @if($soal->gambar_soal)
                                                        <div class="mt-1 flex items-center gap-1.5 text-xs text-gray-500">
                                                            <x-heroicon-m-photo class="w-3.5 h-3.5 text-gray-400" /> Ada Gambar
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right space-x-2">
                                                    <button wire:click="editSoal({{ $soal->id }})" 
                                                            class="inline-flex items-center p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition">
                                                        <x-heroicon-o-pencil-square class="w-4 h-4" />
                                                    </button>
                                                    <button wire:click="konfirmasiHapus({{ $soal->id }})"
                                                            class="inline-flex items-center p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition">
                                                        <x-heroicon-o-trash class="w-4 h-4" />
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination Footer --}}
                            @if($this->soalPaginator && $this->soalPaginator->hasPages())
                                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                                    {{ $this->soalPaginator->links() }}
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        @endif

        {{-- CONFIRM DELETE MODAL --}}
        @if($confirmDeleteId)
            <div class="bs-modal-overlay">
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 max-w-sm w-full mx-4 shadow-xl border border-gray-200 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Soal?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Apakah Anda yakin ingin menghapus soal #{{ $confirmDeleteId }} secara permanen? Data yang sudah dihapus tidak dapat dipulihkan.
                    </p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button wire:click="batalHapus" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">Batal</button>
                        <button wire:click="hapusSoal" class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition">Hapus</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- CONFIRM BULK DELETE MODAL --}}
        @if($showBulkDeleteModal)
            <div class="bs-modal-overlay">
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 max-w-sm w-full mx-4 shadow-xl border border-gray-200 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Soal Terpilih?</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Apakah Anda yakin ingin menghapus sebanyak {{ count($selectedSoalBulk) }} soal yang dipilih secara permanen? Data yang sudah dihapus tidak dapat dipulihkan.
                    </p>
                    <div class="mt-6 flex justify-end gap-3">
                        <button wire:click="batalBulkDelete" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">Batal</button>
                        <button wire:click="bulkDeleteSoal" class="px-4 py-2 text-sm bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-semibold">Hapus Semua</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- ADD / EDIT SOAL MODAL --}}
        @if($showModal)
            <div class="bs-modal-overlay">
                <div class="bs-modal-content mx-4 my-8">
                    {{-- Modal Header --}}
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="text-lg font-bold">{{ $editingId ? 'Edit Soal' : 'Tambah Soal' }} - {{ $selectedKelasNama }}</h3>
                        <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <x-heroicon-o-x-mark class="w-6 h-6" />
                        </button>
                    </div>

                    {{-- Modal Body (2 Columns: Form & Live Preview) --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-6">
                        {{-- Col 1: Form --}}
                        <div class="lg:col-span-7 space-y-6">
                            {{-- Tipe Soal Switch --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipe Soal</label>
                                <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                                    <button type="button" 
                                            wire:click="$set('modalMode', 'pilihan_ganda')"
                                            class="flex-1 text-center py-2 text-sm font-bold rounded-md transition {{ $modalMode === 'pilihan_ganda' ? 'bg-white dark:bg-gray-700 text-primary dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-900 dark:hover:text-gray-200' }}">
                                        Pilihan Ganda
                                    </button>
                                    <button type="button" 
                                            wire:click="$set('modalMode', 'esai')"
                                            class="flex-1 text-center py-2 text-sm font-bold rounded-md transition {{ $modalMode === 'esai' ? 'bg-white dark:bg-gray-700 text-primary dark:text-white shadow-sm' : 'text-gray-500 hover:text-gray-900 dark:hover:text-gray-200' }}">
                                        Esai
                                    </button>
                                </div>
                            </div>

                            {{-- Select Kelas --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                                <select wire:model="formKelasId" 
                                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih Kelas...</option>
                                    @foreach($this->kelasOptions as $kid => $knama)
                                        <option value="{{ $kid }}">{{ $knama }}</option>
                                    @endforeach
                                </select>
                                @error('formKelasId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Select Mapel --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Mata Pelajaran</label>
                                <select wire:model="formMapelId" 
                                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih Mapel...</option>
                                    @foreach($this->mapelOptions as $mid => $mnama)
                                        <option value="{{ $mid }}">{{ $mnama }}</option>
                                    @endforeach
                                </select>
                                @error('formMapelId') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Pertanyaan --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Pertanyaan</label>
                                <textarea wire:model.live="formPertanyaan" 
                                          rows="3" 
                                          placeholder="Masukkan teks soal..."
                                          class="w-full rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary focus:border-primary"></textarea>
                                @error('formPertanyaan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Gambar Soal (Upload) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Gambar Soal (Opsional)</label>
                                <input type="file" wire:model="formGambarSoal" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-800 dark:file:text-gray-300" />
                                @error('formGambarSoal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                            </div>

                            @if($modalMode === 'pilihan_ganda')
                                {{-- OPSI JAWABAN (A-D) --}}
                                <div class="space-y-4 pt-2">
                                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Opsi Jawaban & Jawaban Benar</label>
                                    @foreach(['A', 'B', 'C', 'D'] as $lbl)
                                        <div class="p-3 border border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/40 rounded-xl space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-bold text-gray-600 dark:text-gray-400">Opsi {{ $lbl }}</span>
                                                <label class="inline-flex items-center gap-1.5 text-xs cursor-pointer">
                                                    <input type="radio" 
                                                           name="jawaban_benar" 
                                                           value="{{ $lbl }}" 
                                                           wire:model.live="formJawabanBenar"
                                                           class="text-primary focus:ring-primary" />
                                                    <span class="font-semibold {{ $formJawabanBenar === $lbl ? 'text-primary dark:text-primary-fixed' : 'text-gray-500' }}">Benar</span>
                                                </label>
                                            </div>
                                            <input type="text" 
                                                   wire:model.live="formOpsi.{{ $lbl }}.teks" 
                                                   placeholder="Teks opsi..."
                                                   class="w-full rounded-lg text-sm border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary focus:border-primary" />
                                            <div class="flex items-center gap-2">
                                                <input type="file" 
                                                       wire:model="formOpsi.{{ $lbl }}.gambar" 
                                                       accept="image/*"
                                                       class="block w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-gray-800 dark:file:text-gray-300" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                {{-- KUNCI ESAI --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                        Kunci Jawaban / Rubrik Penilaian <span class="text-xs text-gray-400 font-normal">(opsional)</span>
                                    </label>
                                    <textarea wire:model.live="formKunciEsai" 
                                              rows="4" 
                                              placeholder="Tulis kunci jawaban atau panduan nilai..."
                                              class="w-full rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary focus:border-primary"></textarea>
                                </div>
                            @endif
                        </div>

                        {{-- Col 2: Live Preview --}}
                        <div class="lg:col-span-5 border-t lg:border-t-0 lg:border-l border-gray-100 dark:border-gray-800 pt-6 lg:pt-0 lg:pl-6 space-y-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Live Preview</h4>
                            
                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5 border border-gray-100 dark:border-gray-800 min-h-[300px] flex flex-col justify-between">
                                <div class="space-y-4">
                                    {{-- Soal Text --}}
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white leading-relaxed">
                                            {!! nl2br(e($formPertanyaan ?: 'Pertanyaan akan muncul di sini...')) !!}
                                        </p>
                                        {{-- Temp Image Preview --}}
                                        @if($formGambarSoal)
                                            <div class="mt-3">
                                                <img src="{{ $formGambarSoal->temporaryUrl() }}" class="max-h-40 rounded-lg object-contain shadow-sm border" />
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Answers Preview --}}
                                    @if($modalMode === 'pilihan_ganda')
                                        <div class="space-y-2">
                                            @foreach(['A', 'B', 'C', 'D'] as $lbl)
                                                <div class="flex items-center gap-3 p-2.5 rounded-lg border {{ $formJawabanBenar === $lbl ? 'bg-primary/10 border-primary/30 dark:bg-primary/20 dark:border-primary/40' : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700' }}">
                                                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-extrabold {{ $formJawabanBenar === $lbl ? 'bg-primary text-white shadow' : 'bg-gray-100 dark:bg-gray-700 text-gray-500' }}">
                                                        {{ $lbl }}
                                                    </span>
                                                    <div class="text-sm flex-1">
                                                        {{ $formOpsi[$lbl]['teks'] ?: 'Opsi Jawaban ' . $lbl }}
                                                        @if($formOpsi[$lbl]['gambar'])
                                                            <div class="mt-1">
                                                                <img src="{{ $formOpsi[$lbl]['gambar']->temporaryUrl() }}" class="max-h-20 rounded border" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        {{-- Esai lines --}}
                                        <div class="space-y-1 pt-4">
                                            <div class="border-b border-dashed border-gray-300 dark:border-gray-600 h-8"></div>
                                            <div class="border-b border-dashed border-gray-300 dark:border-gray-600 h-8"></div>
                                            <div class="border-b border-dashed border-gray-300 dark:border-gray-600 h-8"></div>
                                            <div class="border-b border-dashed border-gray-300 dark:border-gray-600 h-8"></div>
                                        </div>
                                        @if($formKunciEsai)
                                            <div class="mt-4 p-3 bg-emerald-50 dark:bg-emerald-950/15 rounded-lg border border-emerald-100 dark:border-emerald-900/30 text-xs">
                                                <strong class="text-emerald-800 dark:text-emerald-400">Kunci:</strong>
                                                <p class="text-emerald-700 dark:text-emerald-300 mt-1">{!! nl2br(e($formKunciEsai)) !!}</p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40">
                        <button type="button" 
                                wire:click="$set('showModal', false)" 
                                class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">
                            Batal
                        </button>
                        <button type="button" 
                                wire:click="simpanSoal" 
                                class="px-5 py-2 text-sm bg-primary hover:opacity-90 text-white font-semibold rounded-lg transition shadow">
                            {{ $editingId ? 'Simpan Perubahan' : 'Tambah Soal' }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
