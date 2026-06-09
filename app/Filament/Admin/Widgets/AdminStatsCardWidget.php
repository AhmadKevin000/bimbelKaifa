<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class AdminStatsCardWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.admin-stats-card-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function getViewData(): array
    {
        $totalGuru = \App\Models\Guru::count();
        $totalSiswa = \App\Models\Siswa::count();
        $totalKelas = \App\Models\Kelas::count();
        $totalMapel = \App\Models\Mapel::count();

        // Count today's sessions
        $kelasHariIni = \App\Models\SesiKelas::whereDate('tanggal', today())->count();

        return [
            'stats' => [
                [
                    'label' => 'Total Guru',
                    'value' => $totalGuru,
                    'description' => 'Tenaga pendidik aktif',
                    'icon' => 'heroicon-o-user-group',
                    'badge' => 'Aktif',
                    'gradient' => 'linear-gradient(135deg, #22C55E 0%, #16A34A 50%, #15803D 100%)',
                    'shadow' => 'rgba(34, 197, 94, 0.35)',
                ],
                [
                    'label' => 'Total Siswa',
                    'value' => $totalSiswa,
                    'description' => 'Siswa terdaftar',
                    'icon' => 'heroicon-o-academic-cap',
                    'badge' => 'Terdaftar',
                    'gradient' => 'linear-gradient(135deg, #3B82F6 0%, #2563EB 50%, #1D4ED8 100%)',
                    'shadow' => 'rgba(59, 130, 246, 0.35)',
                ],
                [
                    'label' => 'Total Kelas',
                    'value' => $totalKelas,
                    'description' => 'Ruang kelas tersedia',
                    'icon' => 'heroicon-o-home-modern',
                    'badge' => 'Tersedia',
                    'gradient' => 'linear-gradient(135deg, #06B6D4 0%, #0891B2 50%, #0E7490 100%)',
                    'shadow' => 'rgba(6, 182, 212, 0.35)',
                ],
                [
                    'label' => 'Kelas Hari Ini',
                    'value' => $kelasHariIni,
                    'description' => 'Sesi berjalan hari ini',
                    'icon' => 'heroicon-o-book-open',
                    'badge' => 'Hari Ini',
                    'gradient' => 'linear-gradient(135deg, #F97316 0%, #EA580C 50%, #C2410C 100%)',
                    'shadow' => 'rgba(249, 115, 22, 0.35)',
                ],
            ],
        ];
    }
}
