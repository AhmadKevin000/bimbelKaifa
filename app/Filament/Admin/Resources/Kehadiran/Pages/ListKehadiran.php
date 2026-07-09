<?php

namespace App\Filament\Admin\Resources\Kehadiran\Pages;

use App\Filament\Admin\Resources\Kehadiran\KehadiranResource;
use App\Models\SesiKelas;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Notifications\Notification;

class ListKehadiran extends ListRecords
{
    protected static string $resource = KehadiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sinkronisasi')
                ->label('Sinkronisasi Sesi')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Sinkronisasi Sesi Kehadiran')
                ->modalDescription('Sistem akan membuat sesi baru untuk semua kelas yang sesi terakhirnya sudah selesai lebih dari 7 hari lalu. Lanjutkan?')
                ->modalSubmitActionLabel('Ya, Sinkronisasi')
                ->action(function () {
                    $today = Carbon::today();
                    $count = 0;

                    // Ambil semua sesi yang sudah "selesai" dan tanggalnya > 7 hari lalu
                    $completedSessions = SesiKelas::query()
                        ->whereHas('absensiGuru', fn($q) => $q->where('status', 'selesai'))
                        ->where('tanggal', '<=', $today->copy()->subDays(7))
                        ->get();

                    foreach ($completedSessions as $session) {
                        // Cek apakah sudah ada sesi lebih baru untuk pengajaran + jadwal_sesi yang sama
                        $existsNewer = SesiKelas::where('jadwal_sesi_id', $session->jadwal_sesi_id)
                            ->where('pengajaran_id', $session->pengajaran_id)
                            ->where('tanggal', '>', $session->tanggal)
                            ->exists();

                        if ($existsNewer) {
                            continue; // Sudah ada sesi baru, skip
                        }

                        // Buat sesi baru untuk hari ini
                        SesiKelas::updateOrCreate(
                            [
                                'jadwal_sesi_id' => $session->jadwal_sesi_id,
                                'pengajaran_id' => $session->pengajaran_id,
                                'tanggal' => $today->format('Y-m-d'),
                            ],
                            [
                                'semester' => $session->semester,
                            ]
                        );

                        $count++;
                    }

                    if ($count > 0) {
                        Notification::make()
                            ->title('Sinkronisasi Berhasil')
                            ->body("{$count} sesi baru berhasil dibuat untuk hari ini.")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Tidak Ada Sesi untuk Disinkronisasi')
                            ->body('Semua sesi sudah up-to-date atau belum ada sesi yang selesai lebih dari 7 hari.')
                            ->info()
                            ->send();
                    }
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            'aktif' => Tab::make()
                ->label('Aktif / Belum Selesai')
                ->modifyQueryUsing(
                    fn($query) => $query
                        ->where(function ($q) {
                            $q->whereDoesntHave('absensiGuru')
                                ->orWhereHas('absensiGuru', fn($sub) => $sub->where('status', '!=', 'selesai'));
                        })
                ),
            'riwayat' => Tab::make()
                ->label('Riwayat Selesai')
                ->modifyQueryUsing(fn($query) => $query->whereHas('absensiGuru', fn($q) => $q->where('status', 'selesai'))),
        ];
    }
}
