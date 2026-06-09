<x-filament::page>
    {{-- Styles: resources/css/gaji-page.css — diinjek via renderHook di GuruPanelProvider --}}

    {{-- Header --}}
    <div class="gp-header">
        <div class="gp-header-left">
            <h1 style="display: flex; align-items: center; gap: 0.5rem;">
                <x-heroicon-o-banknotes style="width: 1.5rem; height: 1.5rem; color: #6b7280; flex-shrink: 0;" />
                <span>Riwayat Gaji</span>
            </h1>
            <p>Data penggajian untuk {{ $namaGuru }}</p>
        </div>
        <span style="color:#fde68a; font-size:.85rem; font-weight:600;">Tahun {{ $filterTahun }}</span>
    </div>

    {{-- Stats --}}
    <div class="gp-stats">
        <div class="gp-stat">
            <div class="gp-stat-icon gp-stat-icon-green">
                <x-heroicon-o-check-circle style="width: 1.25rem; height: 1.25rem; color: #10b981; flex-shrink: 0;" />
            </div>
            <div>
                <p class="gp-stat-val gp-stat-green">Rp {{ number_format($totalDiterima, 0, ',', '.') }}</p>
                <p class="gp-stat-lbl">Total Diterima ({{ $filterTahun }})</p>
            </div>
        </div>
        <div class="gp-stat">
            <div class="gp-stat-icon gp-stat-icon-amber">
                <x-heroicon-o-clock style="width: 1.25rem; height: 1.25rem; color: #d97706; flex-shrink: 0;" />
            </div>
            <div>
                <p class="gp-stat-val gp-stat-amber">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                <p class="gp-stat-lbl">Total Pending (semua tahun)</p>
            </div>
        </div>
        <div class="gp-stat">
            <div class="gp-stat-icon gp-stat-icon-blue">
                <x-heroicon-o-document-text style="width: 1.25rem; height: 1.25rem; color: #2563eb; flex-shrink: 0;" />
            </div>
            <div>
                <p class="gp-stat-val">{{ $totalSesi }}</p>
                <p class="gp-stat-lbl">Jumlah Record Gaji</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="gp-filter-bar">
        <label>Filter Tahun:</label>
        <select class="gp-select" wire:model="filterTahun">
            @foreach($tahunTersedia as $tahun)
                <option value="{{ $tahun }}" @selected($filterTahun == $tahun)>{{ $tahun }}</option>
            @endforeach
        </select>
        <button class="gp-btn-filter" wire:click="setTahun('{{ $filterTahun }}')">Terapkan</button>
    </div>

    {{-- Table --}}
    {{ $this->table }}
</x-filament::page>