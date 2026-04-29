<x-filament::page>
    {{-- Styles: resources/css/jadwal-page.css — diinjek via renderHook di GuruPanelProvider --}}

    {{-- Header --}}
    <div class="jp-header">
        <div class="jp-header-left">
            <h1>📅 Jadwal Mengajar</h1>
            <p>Daftar sesi mengajar {{ $namaGuru }}</p>
        </div>
        <span style="color:#a7f3d0; font-size:.85rem; font-weight:600;">{{ $labelBulan }} {{ $filterTahun }}</span>
    </div>

    {{-- Stats --}}
    <div class="jp-stats">
        <div class="jp-stat">
            <div class="jp-stat-icon jp-stat-icon-blue">📚</div>
            <div>
                <p class="jp-stat-val">{{ $totalSesi }}</p>
                <p class="jp-stat-lbl">Total Sesi</p>
            </div>
        </div>
        <div class="jp-stat">
            <div class="jp-stat-icon jp-stat-icon-green">✅</div>
            <div>
                <p class="jp-stat-val">{{ $sudahHadir }}</p>
                <p class="jp-stat-lbl">Sudah Hadir</p>
            </div>
        </div>
        <div class="jp-stat">
            <div class="jp-stat-icon jp-stat-icon-amber">⏳</div>
            <div>
                <p class="jp-stat-val">{{ $belumAbsen }}</p>
                <p class="jp-stat-lbl">Belum Absen</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="jp-filter-bar">
        <label>Filter:</label>
        <select class="jp-select" wire:model="filterBulan">
            @foreach($opsiBulan as $opt)
                <option value="{{ $opt['value'] }}" @selected($filterBulan == $opt['value'])>{{ $opt['label'] }}</option>
            @endforeach
        </select>
        <select class="jp-select" wire:model="filterTahun">
            @foreach($opsiTahun as $opt)
                <option value="{{ $opt['value'] }}" @selected($filterTahun == $opt['value'])>{{ $opt['label'] }}</option>
            @endforeach
        </select>
        <button class="jp-btn-filter" wire:click="setFilter('{{ $filterBulan }}', '{{ $filterTahun }}')">Terapkan</button>
    </div>

    {{-- Table --}}
    {{ $this->table }}
</x-filament::page>
