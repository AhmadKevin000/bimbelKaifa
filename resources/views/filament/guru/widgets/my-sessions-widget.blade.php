<x-filament-widgets::widget>
<style>
/* ===================== MY SESSIONS WIDGET ===================== */
.ms-wrap { display: flex; flex-direction: column; gap: 1rem; }

/* --- Stat Cards (dashboard style) --- */
.ms-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: .75rem;
}

.ms-stat-card {
    border-radius: .75rem;
    border: 1px solid #e5e7eb;
    background: #fff;
    padding: 1.1rem 1.25rem 1rem;
    display: flex; flex-direction: column; gap: .5rem;
    position: relative; overflow: hidden;
}
.dark .ms-stat-card { background: #1f2937; border-color: #374151; }

/* coloured left accent bar */
.ms-stat-card::before {
    content: ''; position: absolute;
    left: 0; top: 0; bottom: 0; width: 4px;
    border-radius: .75rem 0 0 .75rem;
}
.ms-stat-card.total::before { background: #8b5cf6; }
.ms-stat-card.hadir::before { background: #10b981; }
.ms-stat-card.absen::before { background: #ef4444; }
.ms-stat-card.belum::before { background: #f59e0b; }

.ms-stat-top {
    display: flex; align-items: flex-start; justify-content: space-between;
}

.ms-stat-value {
    font-size: 1.75rem; font-weight: 700;
    color: #111827; line-height: 1;
}
.dark .ms-stat-value { color: #f9fafb; }

.ms-stat-title {
    font-size: .78rem; font-weight: 600;
    color: #6b7280; margin-top: .25rem;
}

.ms-stat-icon {
    width: 2.25rem; height: 2.25rem; border-radius: .4rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ms-stat-icon.total { background: #ede9fe; }
.ms-stat-icon.hadir { background: #d1fae5; }
.ms-stat-icon.absen { background: #fee2e2; }
.ms-stat-icon.belum { background: #fef9c3; }
.dark .ms-stat-icon.total { background: #4c1d9533; }
.dark .ms-stat-icon.hadir { background: #064e3b33; }
.dark .ms-stat-icon.absen { background: #7f1d1d33; }
.dark .ms-stat-icon.belum { background: #78350f33; }

.ms-stat-desc {
    display: flex; align-items: center; gap: .35rem;
    font-size: .72rem; color: #9ca3af; margin-top: .1rem;
}

/* --- Filter Bar --- */
.ms-filter-bar {
    display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    padding: .75rem 1rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: .75rem;
}
.dark .ms-filter-bar { background: #1f2937; border-color: #374151; }

.ms-filter-label {
    font-size: .75rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .04em;
    color: #6b7280; white-space: nowrap;
}

.ms-filter-select {
    background: #f9fafb; border: 1px solid #d1d5db;
    border-radius: .5rem; padding: 6px 10px;
    font-size: .8rem; color: #111827; cursor: pointer;
}
.dark .ms-filter-select { background: #374151; border-color: #4b5563; color: #f9fafb; }

/* --- Table --- */
.ms-table-wrap {
    border-radius: .75rem;
    border: 1px solid #e5e7eb;
    background: #fff;
    overflow: hidden;
}
.dark .ms-table-wrap { background: #1f2937; border-color: #374151; }

.ms-table {
    width: 100%; border-collapse: collapse;
    font-size: .82rem;
}

.ms-table thead tr {
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
}
.dark .ms-table thead tr { border-bottom-color: #374151; background: #111827; }

.ms-table th {
    padding: .65rem 1rem;
    text-align: left; font-size: .72rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .05em; color: #6b7280;
}

.ms-table tbody tr {
    border-top: 1px solid #f3f4f6;
    transition: background .15s;
}
.ms-table tbody tr:hover { background: #f9fafb; }
.dark .ms-table tbody tr { border-top-color: #374151; }
.dark .ms-table tbody tr:hover { background: #374151; }

.ms-table td {
    padding: .75rem 1rem;
    vertical-align: middle;
    color: #111827;
}
.dark .ms-table td { color: #e5e7eb; }

/* --- Badges --- */
.ms-badge {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 999px;
    font-size: .68rem; font-weight: 600; white-space: nowrap;
}
.ms-badge.hadir { background: #d1fae5; color: #065f46; }
.ms-badge.absen { background: #fee2e2; color: #991b1b; }
.ms-badge.belum { background: #fef9c3; color: #854d0e; }

.dark .ms-badge.hadir { background: #064e3b55; color: #6ee7b7; }
.dark .ms-badge.absen { background: #7f1d1d55; color: #fca5a5; }
.dark .ms-badge.belum { background: #713f1255; color: #fde68a; }

/* --- Session Info Cell --- */
.ms-session-name { font-weight: 600; color: #111827; }
.dark .ms-session-name { color: #f9fafb; }
.ms-session-time { font-size: .72rem; color: #6b7280; margin-top: 2px; }

/* --- Empty State --- */
.ms-empty {
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 3.5rem; text-align: center;
}
.ms-empty-icon { font-size: 2.5rem; margin-bottom: .5rem; }
.ms-empty-text { font-size: .875rem; color: #6b7280; margin: 0; }

/* --- Info Bar --- */
.ms-info-bar {
    display: flex; align-items: center; gap: .5rem;
    padding: .75rem 1rem;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: .75rem;
    font-size: .8rem; color: #166534;
}
.dark .ms-info-bar { background: #14532d22; border-color: #14532d; color: #86efac; }
</style>

<div class="ms-wrap">

    {{-- Stat Summary Cards (dashboard style) --}}
    @php $stats = $this->getStats(); @endphp
    <div class="ms-stats">

        {{-- Total Sesi --}}
        <div class="ms-stat-card total">
            <div class="ms-stat-top">
                <div>
                    <div class="ms-stat-value">{{ $stats['total'] }}</div>
                    <div class="ms-stat-title">Total Sesi</div>
                </div>
                <div class="ms-stat-icon total">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#8b5cf6" style="width:1.2rem;height:1.2rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
            </div>
            <div class="ms-stat-desc">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#8b5cf6" style="width:.85rem;height:.85rem;flex-shrink:0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.24a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z" clip-rule="evenodd" />
                </svg>
                Semua sesi yang tercatat
            </div>
        </div>

        {{-- Hadir --}}
        <div class="ms-stat-card hadir">
            <div class="ms-stat-top">
                <div>
                    <div class="ms-stat-value">{{ $stats['hadir'] }}</div>
                    <div class="ms-stat-title">Hadir</div>
                </div>
                <div class="ms-stat-icon hadir">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:1.2rem;height:1.2rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ms-stat-desc">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#10b981" style="width:.85rem;height:.85rem;flex-shrink:0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                Sesi dengan kehadiran
            </div>
        </div>

        {{-- Absen --}}
        <div class="ms-stat-card absen">
            <div class="ms-stat-top">
                <div>
                    <div class="ms-stat-value">{{ $stats['absen'] }}</div>
                    <div class="ms-stat-title">Absen</div>
                </div>
                <div class="ms-stat-icon absen">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ef4444" style="width:1.2rem;height:1.2rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ms-stat-desc">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#ef4444" style="width:.85rem;height:.85rem;flex-shrink:0">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
                Sesi tidak hadir
            </div>
        </div>

        {{-- Belum Absen --}}
        <div class="ms-stat-card belum">
            <div class="ms-stat-top">
                <div>
                    <div class="ms-stat-value">{{ $stats['belum'] }}</div>
                    <div class="ms-stat-title">Belum Absen</div>
                </div>
                <div class="ms-stat-icon belum">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#f59e0b" style="width:1.2rem;height:1.2rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ms-stat-desc">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#f59e0b" style="width:.85rem;height:.85rem;flex-shrink:0">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                Belum tercatat kehadiran
            </div>
        </div>

    </div>

    {{-- Filter Bar --}}
    <div class="ms-filter-bar">
        <span class="ms-filter-label">Filter</span>

        <select wire:model.live="filterSemester" class="ms-filter-select">
            <option value="">Semua Semester</option>
            @foreach($this->getSemesterList() as $sem)
                <option value="{{ $sem }}">Semester {{ $sem }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterStatus" class="ms-filter-select">
            <option value="">Semua Status</option>
            <option value="hadir">Hadir</option>
            <option value="absen">Absen</option>
            <option value="belum">Belum Absen</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="ms-table-wrap">
        @php $sesiList = $this->getSesiList(); @endphp

        @if($sesiList->isEmpty())
            <div class="ms-empty">
                <div class="ms-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="#d1d5db" style="width:3rem;height:3rem;margin-bottom:.5rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <p class="ms-empty-text">Tidak ada sesi ditemukan.</p>
            </div>
        @else
            <table class="ms-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Sesi / Jam</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Semester</th>
                        <th>Status Absensi</th>
                        <th>Check In / Out</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sesiList as $sesi)
                        @php
                            $absensi = $sesi->absensiGuru;
                            $status  = $absensi?->status ?? 'belum';
                        @endphp
                        <tr>
                            {{-- Tanggal --}}
                            <td>
                                {{ \Carbon\Carbon::parse($sesi->tanggal)->format('d M Y') }}
                            </td>

                            {{-- Sesi / Jam --}}
                            <td>
                                @if($sesi->jadwalSesi)
                                    <div class="ms-session-name">{{ $sesi->jadwalSesi->nama }}</div>
                                    <div class="ms-session-time">
                                        {{ \Carbon\Carbon::parse($sesi->jadwalSesi->jam_mulai)->format('H:i') }}
                                        –
                                        {{ \Carbon\Carbon::parse($sesi->jadwalSesi->jam_selesai)->format('H:i') }}
                                    </div>
                                @else
                                    <span style="color:#9ca3af">–</span>
                                @endif
                            </td>

                            {{-- Kelas --}}
                            <td>{{ $sesi->kelas_name_snapshot ?? $sesi->pengajaran?->kelas?->nama_kelas ?? '–' }}</td>

                            {{-- Mata Pelajaran --}}
                            <td>
                                {{ $sesi->mapel_name_snapshot ?? $sesi->pengajaran?->mapel?->nama ?? '–' }}
                            </td>

                            {{-- Semester --}}
                            <td>{{ $sesi->semester ?? '–' }}</td>

                            {{-- Status Absensi --}}
                            <td>
                                <span class="ms-badge {{ $status }}" style="display: inline-flex; align-items: center;">
                                    @if($status === 'hadir')
                                        <x-heroicon-m-check-circle style="width: 1rem; height: 1rem; margin-right: 0.25rem; flex-shrink: 0;" />
                                        <span>Hadir</span>
                                    @elseif($status === 'absen')
                                        <x-heroicon-m-x-circle style="width: 1rem; height: 1rem; margin-right: 0.25rem; flex-shrink: 0;" />
                                        <span>Absen</span>
                                    @else
                                        <x-heroicon-m-clock style="width: 1rem; height: 1rem; margin-right: 0.25rem; flex-shrink: 0;" />
                                        <span>Belum</span>
                                    @endif
                                </span>
                            </td>

                            {{-- Check In / Out --}}
                            <td>
                                @if($absensi && $absensi->check_in)
                                    <div style="font-size:.75rem; display: flex; align-items: center; gap: 0.25rem;">
                                        <x-heroicon-m-clock style="width: 0.95rem; height: 0.95rem; color: #9ca3af; flex-shrink: 0;" />
                                        <span>
                                            {{ \Carbon\Carbon::parse($absensi->check_in)->format('H:i') }}
                                            @if($absensi->check_out)
                                                – {{ \Carbon\Carbon::parse($absensi->check_out)->format('H:i') }}
                                            @else
                                                <span style="color:#9ca3af">– –</span>
                                            @endif
                                        </span>
                                    </div>
                                @else
                                    <span style="color:#9ca3af; font-size:.75rem">Belum absen</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Info Bar --}}
    <div class="ms-info-bar">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:1rem;height:1rem;flex-shrink:0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        Data sesi ditampilkan berdasarkan pengajaran yang telah Anda ampu. Perubahan data dilakukan oleh administrator.
    </div>

</div>
</x-filament-widgets::widget>
