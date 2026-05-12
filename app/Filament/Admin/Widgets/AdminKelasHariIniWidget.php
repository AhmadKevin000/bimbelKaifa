<?php

namespace App\Filament\Admin\Widgets;

use App\Models\SesiKelas;
use Filament\Widgets\Widget;

class AdminKelasHariIniWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.admin-kelas-hari-ini-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function getViewData(): array
    {
        $kelasHariIni = SesiKelas::whereDate('tanggal', today())
            ->with([
                'jadwalSesi',
                'pengajaran.kelas',
                'pengajaran.mapel',
                'pengajaran.guru',
                'absensiGuru',
            ])
            ->get()
            ->sortBy(fn ($sesi) => optional($sesi->jadwalSesi)->jam_mulai)
            ->map(function ($sesi) {
                $jamMulai = optional($sesi->jadwalSesi)->jam_mulai
                    ? \Carbon\Carbon::parse($sesi->jadwalSesi->jam_mulai)->format('H:i')
                    : '-';
                $jamSelesai = optional($sesi->jadwalSesi)->jam_selesai
                    ? \Carbon\Carbon::parse($sesi->jadwalSesi->jam_selesai)->format('H:i')
                    : '-';

                return [
                    'waktu' => $jamMulai . ' - ' . $jamSelesai,
                    'kelas' => optional($sesi->pengajaran?->kelas)->nama_kelas ?? '-',
                    'mapel' => optional($sesi->pengajaran?->mapel)->nama ?? '-',
                    'guru' => optional($sesi->pengajaran?->guru)->nama ?? '-',
                    'status' => $sesi->absensiGuru ? 'Berlangsung' : 'Terjadwal',
                ];
            })
            ->values();

        return [
            'kelasHariIni' => $kelasHariIni,
            'tanggal' => now()->locale('id')->isoFormat('dddd, D MMMM Y'),
        ];
    }
}
