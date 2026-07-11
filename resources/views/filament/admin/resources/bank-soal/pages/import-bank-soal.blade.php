<x-filament-panels::page>
    <div class="space-y-6">

        @if($prefillJenjangNama)
            <div class="bg-primary-50 dark:bg-primary-950/20 border border-primary-200 dark:border-primary-800 rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    <div>
                        <p class="text-sm font-semibold text-primary-800 dark:text-primary-300">Import Soal untuk Jenjang: <span class="underline font-bold">{{ $prefillJenjangNama }}</span></p>
                        <p class="text-xs text-primary-700/80 dark:text-primary-400/80 mt-0.5">
                            Baris data Excel disarankan untuk jenjang ini. Baris dengan jenjang lain akan tetap diproses sesuai jenjangnya sendiri di file Excel.
                        </p>
                    </div>
                </div>
                <button wire:click="$set('prefillJenjangId', null); $set('prefillJenjangNama', null);" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline">
                    Abaikan Filter
                </button>
            </div>
        @endif

        {{-- Upload Form --}}
        @if(!$isParsed)
        <div wire:key="upload-form-wrapper">
        <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-header border-b border-gray-100 dark:border-gray-800 pb-3 mb-4">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Upload File</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                {{-- Upload Excel --}}
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        📄 File Excel (.xlsx)
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Satu file berisi 2 sheet: "Pilihan Ganda" dan "Esai".
                        <a href="{{ route('bank-soal.template') }}" class="text-primary-600 dark:text-primary-400 hover:underline" target="_blank">Download template</a>
                    </p>
                    <input type="file" accept=".xlsx,.xls"
                        wire:model="excelFile"
                        class="block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400" />
                    @error('excelFile')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Upload Gambar --}}
                <div class="space-y-2"
                    x-data="{
                        files: [],
                        isDragging: false,
                        uploading: false,
                        uploadProgress: 0,

                        addFiles(newFiles) {
                            Array.from(newFiles).forEach(f => {
                                if (!this.files.find(e => e.name === f.name && e.size === f.size)) {
                                    this.files.push(f);
                                }
                            });
                        },

                        removeFile(idx) { this.files.splice(idx, 1); },

                        fmtSize(b) {
                            if (b < 1024) return b + ' B';
                            if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
                            return (b/1048576).toFixed(1) + ' MB';
                        },

                        async doParse() {
                            if (this.uploading) return;
                            this.uploading = true;
                            this.uploadProgress = 0;

                            if (this.files.length === 0) {
                                try {
                                    await $wire.parse();
                                } finally {
                                    this.uploading = false;
                                }
                                return;
                            }

                            await $wire.set('imageFiles', []);

                            const self = this;

                            $wire.uploadMultiple(
                                'imageFiles',
                                this.files,
                                function() {
                                    self.uploadProgress = 100;
                                    $wire.parse().then(() => {
                                        self.files = [];
                                    }).finally(() => {
                                        self.uploading = false;
                                    });
                                },
                                function(err) {
                                    console.error('Upload error', err);
                                    self.uploading = false;
                                },
                                function(event) {
                                    self.uploadProgress = event.detail.progress;
                                }
                            );
                        }
                    }"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="isDragging = false; addFiles($event.dataTransfer.files)"
                >
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        🖼️ File Gambar (multi-upload, opsional)
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Upload semua gambar yang namanya disebut di kolom <code>gambar_soal</code> atau <code>gambar_opsi_*</code> di Excel.
                        Nama file dicocokkan otomatis (tidak peka huruf besar/kecil). Bisa pilih berkali-kali atau drag & drop.
                    </p>

                    {{-- Drop Zone --}}
                    <div
                        class="mt-2 border-2 border-dashed rounded-xl p-5 text-center cursor-pointer transition"
                        :class="isDragging ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950/20' : 'border-gray-300 dark:border-gray-600 hover:border-emerald-400 hover:bg-gray-50 dark:hover:bg-gray-800/40'"
                        @click="$refs.imgPicker.click()"
                    >
                        <div class="text-2xl mb-1">📁</div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                            Klik atau drag & drop gambar di sini
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, GIF, WebP — maks 5 MB/file</p>
                        <input
                            type="file" x-ref="imgPicker"
                            accept="image/*" multiple
                            class="hidden"
                            @change="addFiles($event.target.files); $event.target.value = ''"
                        >
                    </div>

                    {{-- Image Thumbnail Preview Grid --}}
                    <template x-if="files.length > 0">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider" x-text="files.length + ' gambar dipilih'"></span>
                                <button type="button" @click="files = []" class="text-xs text-red-500 hover:text-red-700 transition font-medium">Hapus semua</button>
                            </div>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                                <template x-for="(file, idx) in files" :key="idx">
                                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 aspect-square">
                                        {{-- Thumbnail --}}
                                        <img
                                            :src="URL.createObjectURL(file)"
                                            class="w-full h-full object-cover"
                                            :alt="file.name"
                                        />
                                        {{-- Overlay on hover --}}
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-1.5 gap-1">
                                            <p class="text-white text-[9px] font-medium text-center leading-tight line-clamp-2 break-all" x-text="file.name"></p>
                                            <p class="text-white/70 text-[8px]" x-text="fmtSize(file.size)"></p>
                                            <button
                                                type="button"
                                                @click.stop="removeFile(idx)"
                                                class="mt-1 inline-flex items-center gap-0.5 px-2 py-0.5 rounded text-[9px] font-semibold bg-red-500 hover:bg-red-600 text-white transition"
                                            >
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Hapus
                                            </button>
                                        </div>
                                        {{-- Success badge --}}
                                        <div class="absolute top-1 left-1 bg-emerald-500 text-white rounded-full w-4 h-4 flex items-center justify-center shadow">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            {{-- Summary bar --}}
                            <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-700 dark:text-emerald-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="files.length + ' gambar siap diupload. Klik Preview & Validasi untuk melanjutkan.'"></span>
                            </div>
                        </div>
                    </template>

                    {{-- Upload progress bar --}}
                    <template x-if="uploading && files.length > 0">
                        <div class="mt-2">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Mengupload gambar...</span>
                                <span x-text="uploadProgress + '%'"></span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full transition-all" :style="'width:' + uploadProgress + '%'"></div>
                            </div>
                        </div>
                    </template>

                    @error('imageFiles.*')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    {{-- Parse Button (inside Alpine scope to access doParse) --}}
                    <div class="mt-6 flex justify-end gap-2">
                        {{-- Button saat Excel sedang diunggah --}}
                        <button
                            type="button"
                            disabled
                            wire:loading
                            wire:target="excelFile"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-300 dark:bg-gray-700 text-gray-500 cursor-not-allowed"
                        >
                            <svg class="w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <span>Mengunggah Excel...</span>
                        </button>

                        {{-- Button saat proses parse Excel berjalan --}}
                        <button
                            type="button"
                            disabled
                            wire:loading
                            wire:target="parse"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-300 dark:bg-gray-700 text-gray-500 cursor-not-allowed"
                        >
                            <svg class="w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <span>Memproses Excel...</span>
                        </button>

                        {{-- Button saat Alpine sedang mengunggah gambar --}}
                        <button
                            type="button"
                            disabled
                            x-show="uploading"
                            wire:loading.remove
                            wire:target="parse, excelFile"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-300 dark:bg-gray-700 text-gray-500 cursor-not-allowed"
                            style="display: none;"
                        >
                            <svg class="w-4 h-4 animate-spin text-gray-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            <span>Mengupload Gambar... (<span x-text="uploadProgress"></span>%)</span>
                        </button>

                        {{-- Button utama saat Idle --}}
                        <button
                            type="button"
                            @click="doParse()"
                            x-show="!uploading"
                            wire:loading.remove
                            wire:target="parse, excelFile"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg transition shadow-sm bg-blue-600 hover:bg-blue-700 text-white !text-white"
                        >
                            <svg class="w-4 h-4 text-white !text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>Preview & Validasi</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @endif

        {{-- Preview Results --}}
        @if($isParsed)
        <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            {{-- Custom Header Area --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-4 border-b border-gray-100 dark:border-gray-800 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Hasil Parsing Soal</h2>
                    <p class="text-xs text-gray-500 mt-1">Silakan periksa detail soal di bawah sebelum menyimpan ke bank soal.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg bg-green-50 dark:bg-green-950/20 text-green-700 dark:text-green-400 border border-green-100 dark:border-green-900/30">
                        ✓ {{ $this->pgValid + $this->esaiValid }} Valid
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-900/30">
                        ✗ {{ $this->pgError + $this->esaiError }} Error
                    </span>

                    <button type="button" wire:click="uploadUlang" wire:key="btn-upload-ulang"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg transition border border-gray-200 dark:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Upload Ulang
                    </button>

                    <button type="button" wire:click="simpanSoal" wire:key="btn-simpan-soal"
                            @if(($this->pgValid + $this->esaiValid) == 0) disabled @endif
                            class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-bold text-white rounded-lg transition shadow-sm {{ ($this->pgValid + $this->esaiValid) > 0 ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-gray-400 dark:bg-gray-700 cursor-not-allowed' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                        <span>Simpan Soal Valid</span>
                    </button>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="border-b border-gray-200 dark:border-gray-700 -mx-6 mb-4">
                <nav class="-mb-px flex">
                    <button wire:click="$set('activeTab', 'pilihan_ganda')"
                        @class([
                            'px-6 py-3 text-sm font-semibold border-b-2 transition',
                            'border-primary-500 text-primary-600 dark:text-primary-400' => $activeTab === 'pilihan_ganda',
                            'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' => $activeTab !== 'pilihan_ganda',
                        ])>
                        Pilihan Ganda
                        <span class="ml-1.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded-full">
                            {{ $pgValidCount + $pgErrorCount }}
                        </span>
                    </button>
                    <button wire:click="$set('activeTab', 'esai')"
                        @class([
                            'px-6 py-3 text-sm font-semibold border-b-2 transition',
                            'border-primary-500 text-primary-600 dark:text-primary-400' => $activeTab === 'esai',
                            'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' => $activeTab !== 'esai',
                        ])>
                        Esai
                        <span class="ml-1.5 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-1.5 py-0.5 rounded-full">
                            {{ $esaiValidCount + $esaiErrorCount }}
                        </span>
                    </button>
                </nav>
            </div>

            {{-- Tab Content: Pilihan Ganda --}}
            @if($activeTab === 'pilihan_ganda')
            @php $parsedPGData = $this->parsedPG; @endphp
            <div class="overflow-x-auto" wire:key="tab-content-pg">
                @if(empty($parsedPGData))
                    <p class="text-center text-gray-500 py-8">Tidak ada baris di sheet Pilihan Ganda.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800 text-left">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jenjang / Mapel</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pertanyaan</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Opsi A-D</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jwb</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($parsedPGData as $row)
                        <tr @class(['bg-red-50 dark:bg-red-900/10' => $row['status'] === 'error'])>
                            <td class="px-4 py-3 text-gray-500">{{ $row['row_num'] }}</td>
                            <td class="px-4 py-3">
                                @if($row['status'] === 'valid')
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">✓ Valid</span>
                                @else
                                    <div>
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full">✗ Error</span>
                                        <ul class="mt-1 text-xs text-red-600 dark:text-red-400 list-disc list-inside">
                                            @foreach($row['errors'] as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                    {{ $row['kelas_nama'] ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $row['jenjang_nama'] }}</div>
                                <div class="text-xs text-gray-500">{{ $row['mapel_nama'] }}</div>
                                @if($prefillJenjangNama && strtolower(trim($row['jenjang_nama'])) !== strtolower(trim($prefillJenjangNama)))
                                    <div class="mt-1 text-[10px] leading-tight text-amber-600 dark:text-amber-400 font-semibold max-w-[150px]">
                                        ⚠️ Baris untuk jenjang lain, tetap akan diproses.
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 max-w-xs">
                                <p class="text-gray-800 dark:text-gray-200 line-clamp-2">{{ $row['pertanyaan'] }}</p>
                                @if($row['gambar_soal'])
                                    <img src="{{ asset('storage/' . $row['gambar_soal']) }}" class="mt-1 h-12 w-auto rounded object-cover" />
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="space-y-1">
                                    @foreach(['a','b','c','d'] as $label)
                                    @if(isset($row['opsi'][$label]))
                                    <div class="flex items-start gap-1 text-xs">
                                        <span class="font-bold text-gray-500">{{ strtoupper($label) }}.</span>
                                        @if($row['opsi'][$label]['teks'])
                                            <span class="text-gray-700 dark:text-gray-300">{{ Str::limit($row['opsi'][$label]['teks'], 30) }}</span>
                                        @endif
                                        @if($row['opsi'][$label]['gambar_path'] ?? null)
                                            <img src="{{ asset('storage/' . $row['opsi'][$label]['gambar_path']) }}" class="h-8 w-auto rounded" />
                                        @endif
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 text-sm font-bold bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300 rounded">
                                    {{ $row['jawaban_benar'] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            @endif

            {{-- Tab Content: Esai --}}
            @if($activeTab === 'esai')
            @php $parsedEsaiData = $this->parsedEsai; @endphp
            <div class="overflow-x-auto" wire:key="tab-content-esai">
                @if(empty($parsedEsaiData))
                    <p class="text-center text-gray-500 py-8">Tidak ada baris di sheet Esai.</p>
                @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800 text-left">
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Jenjang / Mapel</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Pertanyaan</th>
                            <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kunci Jawaban (cuplikan)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($parsedEsaiData as $row)
                        <tr @class(['bg-red-50 dark:bg-red-900/10' => $row['status'] === 'error'])>
                            <td class="px-4 py-3 text-gray-500">{{ $row['row_num'] }}</td>
                            <td class="px-4 py-3">
                                @if($row['status'] === 'valid')
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full">✓ Valid</span>
                                @else
                                    <div>
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full">✗ Error</span>
                                        <ul class="mt-1 text-xs text-red-600 dark:text-red-400 list-disc list-inside">
                                            @foreach($row['errors'] as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                    {{ $row['kelas_nama'] ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800 dark:text-gray-200">{{ $row['jenjang_nama'] }}</div>
                                <div class="text-xs text-gray-500">{{ $row['mapel_nama'] }}</div>
                                @if($prefillJenjangNama && strtolower(trim($row['jenjang_nama'])) !== strtolower(trim($prefillJenjangNama)))
                                    <div class="mt-1 text-[10px] leading-tight text-amber-600 dark:text-amber-400 font-semibold max-w-[150px]">
                                        ⚠️ Baris untuk jenjang lain, tetap akan diproses.
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 max-w-xs">
                                <p class="text-gray-800 dark:text-gray-200 line-clamp-2">{{ $row['pertanyaan'] }}</p>
                                @if($row['gambar_soal'])
                                    <img src="{{ asset('storage/' . $row['gambar_soal']) }}" class="mt-1 h-12 w-auto rounded object-cover" />
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">
                                {{ $row['kunci_jawaban_esai'] ? Str::limit($row['kunci_jawaban_esai'], 80) : '— (tidak ada kunci)' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            @endif
            </div>

            {{-- Commit Errors --}}
            @if(!empty($commitErrors))
            <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-xl p-4 mt-6">
                <h3 class="font-semibold text-red-800 dark:text-red-400 mb-2">Error saat menyimpan:</h3>
                <ul class="text-sm text-red-700 dark:text-red-400 list-disc list-inside space-y-1">
                    @foreach($commitErrors as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        @endif
    </div>
</x-filament-panels::page>
