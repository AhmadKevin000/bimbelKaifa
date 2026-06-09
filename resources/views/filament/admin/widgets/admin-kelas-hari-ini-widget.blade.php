<x-filament-widgets::widget>
<style>
.adm-kelas-card {
    background: #FFFFFF;
    border-radius: 1rem;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
}
.dark .adm-kelas-card {
    background: #1e293b;
    border-color: rgba(255,255,255,0.06);
}
.adm-kelas-header {
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #f1f5f9;
}
.dark .adm-kelas-header {
    border-bottom-color: #334155;
}
.adm-kelas-header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.adm-kelas-header-icon {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 0.5rem;
    background: linear-gradient(135deg, #4364F7 0%, #6FB1FC 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #fff;
    box-shadow: 0 2px 8px rgba(67, 100, 247, 0.3);
}
.adm-kelas-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.dark .adm-kelas-title { color: #f1f5f9; }
.adm-kelas-subtitle {
    font-size: 0.75rem;
    color: #64748b;
    margin: 0.1rem 0 0;
}
.dark .adm-kelas-subtitle { color: #94a3b8; }
.adm-kelas-count {
    font-size: 0.7rem;
    font-weight: 600;
    background: #EEF2FF;
    color: #4F46E5;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
}
.dark .adm-kelas-count {
    background: rgba(79,70,229,0.15);
    color: #818cf8;
}
.adm-kelas-body {
    padding: 0.5rem 1.5rem 1.25rem;
}

/* Empty state */
.adm-kelas-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 0;
    text-align: center;
}
.adm-kelas-empty-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    background: #f0fdf4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 0.75rem;
}
.dark .adm-kelas-empty-icon { background: rgba(34,197,94,0.1); }
.adm-kelas-empty-text {
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}
.dark .adm-kelas-empty-text { color: #d1d5db; }
.adm-kelas-empty-sub {
    font-size: 0.78rem;
    color: #9ca3af;
    margin: 0.25rem 0 0;
}

/* Table */
.adm-kelas-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
}
.adm-kelas-table thead th {
    padding: 0.75rem 0.5rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #94a3b8;
    border-bottom: 2px solid #f1f5f9;
}
.dark .adm-kelas-table thead th {
    color: #64748b;
    border-bottom-color: #334155;
}
.adm-kelas-table tbody td {
    padding: 0.75rem 0.5rem;
    border-bottom: 1px solid #f8fafc;
    color: #334155;
    vertical-align: middle;
}
.dark .adm-kelas-table tbody td {
    border-bottom-color: #1e293b;
    color: #cbd5e1;
}
.adm-kelas-table tbody tr:last-child td {
    border-bottom: none;
}
.adm-kelas-table tbody tr {
    transition: background 0.15s ease;
}
.adm-kelas-table tbody tr:hover {
    background: #f8fafc;
}
.dark .adm-kelas-table tbody tr:hover {
    background: rgba(255,255,255,0.03);
}

.adm-kelas-waktu {
    font-weight: 600;
    white-space: nowrap;
    color: #1e293b;
    font-size: 0.82rem;
}
.dark .adm-kelas-waktu { color: #e2e8f0; }

.adm-badge-kelas {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    border-radius: 0.375rem;
    background: #EEF2FF;
    color: #4338CA;
    font-size: 0.75rem;
    font-weight: 600;
}
.dark .adm-badge-kelas {
    background: rgba(67,56,202,0.15);
    color: #a5b4fc;
}

.adm-badge-guru {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.82rem;
}
.adm-guru-avatar {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    background: linear-gradient(135deg, #4364F7, #6FB1FC);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}

.adm-status-berlangsung {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    border-radius: 999px;
    background: #dcfce7;
    color: #166534;
    font-size: 0.72rem;
    font-weight: 600;
}
.dark .adm-status-berlangsung {
    background: rgba(22,163,74,0.15);
    color: #86efac;
}

.adm-status-terjadwal {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    border-radius: 999px;
    background: #fef3c7;
    color: #92400e;
    font-size: 0.72rem;
    font-weight: 600;
}
.dark .adm-status-terjadwal {
    background: rgba(245,158,11,0.15);
    color: #fcd34d;
}
</style>

<div class="adm-kelas-card">
    <div class="adm-kelas-header">
        <div class="adm-kelas-header-left">
            <div class="adm-kelas-header-icon">
                <x-heroicon-o-clipboard-document-list style="width: 1.25rem; height: 1.25rem; color: #ffffff; flex-shrink: 0;" />
            </div>
            <div>
                <h3 class="adm-kelas-title">Kelas Hari Ini</h3>
                <p class="adm-kelas-subtitle">Jadwal kelas yang berjalan hari ini</p>
            </div>
        </div>
        <span class="adm-kelas-count">{{ $kelasHariIni->count() }} Sesi</span>
    </div>

    <div class="adm-kelas-body">
        @if($kelasHariIni->isEmpty())
            <div class="adm-kelas-empty">
                <div class="adm-kelas-empty-icon">
                    <x-heroicon-o-check-circle style="width: 2.5rem; height: 2.5rem; color: #10b981; flex-shrink: 0;" />
                </div>
                <p class="adm-kelas-empty-text">Tidak ada kelas hari ini</p>
                <p class="adm-kelas-empty-sub">Semua jadwal kosong untuk hari ini</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="adm-kelas-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelasHariIni as $kelas)
                        <tr>
                            <td>
                                <span class="adm-kelas-waktu" style="display:inline-flex; align-items:center; gap:0.25rem;">
                                    <x-heroicon-m-clock style="width: 0.95rem; height: 0.95rem; color: #9ca3af; flex-shrink: 0;" />
                                    <span>{{ $kelas['waktu'] }}</span>
                                </span>
                            </td>
                            <td>
                                <span class="adm-badge-kelas">{{ $kelas['kelas'] }}</span>
                            </td>
                            <td>{{ $kelas['mapel'] }}</td>
                            <td>
                                <span class="adm-badge-guru">
                                    <span class="adm-guru-avatar">{{ mb_strtoupper(mb_substr($kelas['guru'], 0, 1)) }}</span>
                                    {{ $kelas['guru'] }}
                                </span>
                            </td>
                            <td>
                                @if($kelas['status'] === 'Berlangsung')
                                    <span class="adm-status-berlangsung">● Berlangsung</span>
                                @else
                                    <span class="adm-status-terjadwal" style="display:inline-flex; align-items:center; gap:0.25rem;">
                                        <x-heroicon-m-clock style="width: 0.875rem; height: 0.875rem; flex-shrink: 0;" />
                                        <span>Terjadwal</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
</x-filament-widgets::widget>
