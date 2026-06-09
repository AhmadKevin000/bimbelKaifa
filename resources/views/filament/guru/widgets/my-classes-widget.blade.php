<x-filament-widgets::widget>
<style>
.mc-wrap { display: flex; flex-direction: column; gap: 1rem; }

.mc-filter-bar {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: .75rem;
}
.dark .mc-filter-bar { background: #1f2937; border-color: #374151; }

.mc-filter-label {
    font-size: .75rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .04em;
    color: #6b7280; white-space: nowrap;
}

.mc-filter-select {
    background: #f9fafb; border: 1px solid #d1d5db;
    border-radius: .5rem; padding: 6px 10px;
    font-size: .8rem; color: #111827; cursor: pointer;
}
.dark .mc-filter-select { background: #374151; border-color: #4b5563; color: #f9fafb; }

.mc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem;
}

.mc-card {
    border-radius: .75rem;
    border: 1px solid #e5e7eb;
    background: #fff;
    overflow: hidden;
    display: flex; flex-direction: column;
}
.dark .mc-card { background: #1f2937; border-color: #374151; }

.mc-card-header {
    padding: .75rem 1rem;
    display: flex; align-items: center; gap: .625rem;
    border-bottom: 1px solid #f3f4f6;
}
.dark .mc-card-header { border-bottom-color: #374151; }

.mc-icon {
    width: 2.25rem; height: 2.25rem; border-radius: .4rem;
    background: #dbeafe;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dark .mc-icon { background: #1e3a8a33; }

.mc-card-title {
    font-size: .875rem; font-weight: 600; margin: 0;
    color: #111827;
}
.dark .mc-card-title { color: #f9fafb; }

.mc-card-sub {
    font-size: .7rem; color: #6b7280; margin: 0;
}

.mc-badge {
    margin-left: auto;
    padding: 2px 8px; border-radius: 999px;
    background: #eff6ff; color: #1d4ed8;
    font-size: .65rem; font-weight: 600; white-space: nowrap;
}
.dark .mc-badge { background: #1e3a8a33; color: #93c5fd; }

.mc-card-body { padding: .875rem 1rem; flex: 1; }

.mc-row {
    display: flex; justify-content: space-between;
    padding: .35rem 0;
    border-top: 1px solid #f3f4f6;
    font-size: .8rem;
}
.mc-row:first-child { border-top: none; }
.dark .mc-row { border-top-color: #374151; }

.mc-row-label { color: #9ca3af; }
.mc-row-value { font-weight: 500; color: #111827; text-align: right; }
.dark .mc-row-value { color: #f3f4f6; }

.mc-empty {
    grid-column: 1 / -1;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 3rem; text-align: center;
}
.mc-empty-icon { font-size: 2.5rem; margin-bottom: .5rem; }
.mc-empty-text { font-size: .875rem; color: #6b7280; margin: 0; }

.mc-info-bar {
    display: flex; align-items: center; gap: .5rem;
    padding: .75rem 1rem;
    background: #eff6ff; border: 1px solid #bfdbfe;
    border-radius: .75rem;
    font-size: .8rem; color: #1d4ed8;
}
.dark .mc-info-bar { background: #1e3a8a22; border-color: #1e3a8a; color: #93c5fd; }
</style>

<div class="mc-wrap">

    {{-- Filter --}}
    <div class="mc-filter-bar">
        {{-- <span class="mc-filter-label"> Filter Mapel</span> --}}
        <select wire:model.live="filterMapel" class="mc-filter-select">
            <option value="">Semua Mata Pelajaran</option>
            @foreach($this->getMapelList() as $mapel)
                <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Grid --}}
    <div class="mc-grid">
        @forelse($this->getKelas() as $kelas)
            @foreach($kelas->pengajaran as $p)
            <div class="mc-card">
                <div class="mc-card-header">
                    <div class="mc-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3b82f6" style="width:1.25rem;height:1.25rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="mc-card-title">{{ $p->mapel->nama ?? '-' }}</p>
                        <p class="mc-card-sub">{{ $p->mapel->jenjang->nama ?? '-' }}</p>
                    </div>
                    <span class="mc-badge">{{ $kelas->jumlah_siswa }} Siswa</span>
                </div>

                <div class="mc-card-body">
                    <div class="mc-row">
                        <span class="mc-row-label">Kelas</span>
                        <span class="mc-row-value">{{ $kelas->nama_kelas }}</span>
                    </div>
                    <div class="mc-row">
                        <span class="mc-row-label">Jenjang</span>
                        <span class="mc-row-value">{{ $kelas->jenjang }}</span>
                    </div>
                    <div class="mc-row">
                        <span class="mc-row-label">Keterangan</span>
                        <span class="mc-row-value">{{ $kelas->keterangan ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        @empty
            <div class="mc-empty">
                <div class="mc-empty-icon">
                    <x-heroicon-o-academic-cap style="width: 3rem; height: 3rem; color: #cbd5e1; margin: 0 auto;" />
                </div>
                <p class="mc-empty-text">Tidak ada kelas ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- Info Bar --}}
    <div class="mc-info-bar">
        Anda hanya dapat melihat informasi. Perubahan data dilakukan oleh administrator.
    </div>

</div>
</x-filament-widgets::widget>