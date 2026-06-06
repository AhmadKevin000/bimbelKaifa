<?php

namespace App\Filament\Admin\Resources\Kehadiran\Pages;

use App\Filament\Admin\Resources\Kehadiran\KehadiranResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Notifications\Notification;

class ListKehadiran extends ListRecords
{
    protected static string $resource = KehadiranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('sync_today')
                ->label('Sync Jadwal Hari Ini')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->requiresConfirmation()
                ->modalDescription('Cari dan buat otomatis sesi absen hari ini berdasarkan jadwal yang sama persis 7 hari lalu.')
                ->action(function () {
                    $targetDate = now()->format('Y-m-d');
                    \Illuminate\Support\Facades\Artisan::call('app:generate-daily-sessions', [
                        '--date' => $targetDate
                    ]);
                    Notification::make()->title('Sinkronisasi Jadwal Selesai!')->success()->send();
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make()
                ->label('Semua'),
            'aktif' => Tab::make()
                ->label('Aktif / Belum Selesai')
                ->modifyQueryUsing(fn ($query) => $query
                    ->where(function ($q) {
                        $q->whereDoesntHave('absensiGuru')
                          ->orWhereHas('absensiGuru', fn($sub) => $sub->where('status', '!=', 'selesai'));
                    })
                ),
            'riwayat' => Tab::make()
                ->label('Riwayat Selesai')
                ->modifyQueryUsing(fn ($query) => $query->whereHas('absensiGuru', fn($q) => $q->where('status', 'selesai'))),
        ];
    }
}
