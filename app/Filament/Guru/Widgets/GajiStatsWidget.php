<?php

namespace App\Filament\Guru\Widgets;

use App\Models\Guru;
use App\Models\Penggajian;
use App\Models\SesiKelas;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GajiStatsWidget extends StatsOverviewWidget
{
    /**
     * Widget ini digunakan di halaman GajiPage (bukan dashboard),
     * sehingga sort-nya cukup tinggi agar tidak muncul di Dashboard.
     */
    protected static ?int $sort = 10;

    /**
     * Hanya tampilkan di GajiPage — daftarkan secara eksplisit di page tersebut.
     * Widget ini TIDAK akan auto-muncul di dashboard karena hasSortColumn=10
     * dan tidak didaftarkan di Dashboard::getWidgets().
     */
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        /** @var \App\Models\User $user */
        $user = auth()->guard('guru')->user()
               ?? auth()->user();

        $guru = Guru::where('user_id', $user->id)->first();

        if (! $guru) {
            return [
                Stat::make('Total Gaji Diterima', 'Rp 0')
                    ->description('Belum ada data')
                    ->color('gray'),
                Stat::make('Gaji Pending', 'Rp 0')
                    ->description('Belum ada data')
                    ->color('gray'),
                Stat::make('Total Sesi Dibayar', '0')
                    ->description('Belum ada sesi terverifikasi')
                    ->color('gray'),
            ];
        }

        $totalDiterima = Penggajian::where('guru_id', $guru->id)
            ->where('status_pembayaran', 'paid')
            ->sum('nominal');

        $totalPending = Penggajian::where('guru_id', $guru->id)
            ->where('status_pembayaran', '!=', 'paid')
            ->sum('nominal');

        $totalSesiDibayar = Penggajian::where('guru_id', $guru->id)
            ->where('status_pembayaran', 'paid')
            ->count();

        $totalSesiPending = Penggajian::where('guru_id', $guru->id)
            ->where('status_pembayaran', '!=', 'paid')
            ->count();

        return [
            Stat::make('Total Gaji Diterima', 'Rp ' . number_format($totalDiterima, 0, ',', '.'))
                ->description('Semua periode (status: dibayar)')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Gaji Pending', 'Rp ' . number_format($totalPending, 0, ',', '.'))
                ->description("{$totalSesiPending} sesi belum dibayar")
                ->descriptionIcon('heroicon-m-clock')
                ->color($totalPending > 0 ? 'warning' : 'gray'),

            Stat::make('Sesi Terbayar', "{$totalSesiDibayar} sesi")
                ->description('Total sesi dengan pembayaran lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
