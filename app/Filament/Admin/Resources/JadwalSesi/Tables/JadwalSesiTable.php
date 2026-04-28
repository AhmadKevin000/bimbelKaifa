<?php

namespace App\Filament\Admin\Resources\JadwalSesi\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use App\Models\JadwalSesi;
use App\Models\SesiKelas;
use App\Models\Pengajaran;

class JadwalSesiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_hari_ini')
                    ->label('Tanggal Hari Ini')
                    ->getStateUsing(fn () => now()->translatedFormat('d F Y'))
                    ->weight('bold'),
                TextColumn::make('jam_mulai')
                    ->label('Jam')
                    ->getStateUsing(function ($record) {
                        return "{$record->jam_mulai} - {$record->jam_selesai}";
                    })
                    ->sortable(),
                TextColumn::make('durasi')
                    ->label('Durasi')
                    ->formatStateUsing(fn ($state) => "{$state} menit"),
                TextColumn::make('pengajaran_count')
                    ->counts('pengajaran')
                    ->label('Jumlah Kelas')
                    ->badge()
                    ->color('info'),
            ])
            ->actions([
                \Filament\Actions\Action::make('assign_mapel')
                    ->label('Tambahkan Kelas')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        \Filament\Forms\Components\Select::make('semester')
                            ->options([
                                'Semester 1' => 'Semester 1',
                                'Semester 2' => 'Semester 2',
                            ])
                            ->default('Semester 1')
                            ->live()
                            ->required(),
                        \Filament\Forms\Components\Select::make('pengajaran_ids')
                            ->label('Pilih Jadwal Pengajaran')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(function ($get) {
                                $semester = $get('semester');

                                // Ambil semua mapel_id yang sudah ada jadwalnya di semester ini (di sesi MANAPUN)
                                $assignedMapelIds = \App\Models\SesiKelas::where('semester', $semester)
                                    ->join('pengajaran', 'sesi_kelas.pengajaran_id', '=', 'pengajaran.id')
                                    ->pluck('pengajaran.mapel_id')
                                    ->toArray();

                                return Pengajaran::with(['kelas', 'mapel', 'guru'])
                                    ->whereNotIn('mapel_id', $assignedMapelIds) // Hilangkan mapel yg sudah ditambahkan
                                    ->get()
                                    ->mapWithKeys(function ($item) {
                                        $kelas = $item->kelas?->nama_kelas ?? 'Unknown';
                                        $mapel = $item->mapel?->nama ?? 'Unknown';
                                        $guru = $item->guru?->nama ?? 'Unknown';
                                        return [$item->id => "{$kelas} - {$mapel} (Guru: {$guru})"];
                                    });
                            })
                            ->required(),
                    ])
                    ->action(function (JadwalSesi $record, array $data) {
                        $jadwalSesiId = $record->id;
                        $tanggal = now()->toDateString();
                        $semester = $data['semester'];
                        
                        $successCount = 0;
                        
                        foreach ($data['pengajaran_ids'] as $pengajaranId) {
                            $item = Pengajaran::find($pengajaranId);
                            if (!$item) continue;

                            $mapelId = $item->mapel_id;

                            // Validation: lock by mapel per semester (not kelas)
                            $existingOtherSession = SesiKelas::whereHas('pengajaran', function($q) use ($mapelId) {
                                    $q->where('mapel_id', $mapelId);
                                })
                                ->where('semester', $semester)
                                ->where('jadwal_sesi_id', '!=', $jadwalSesiId)
                                ->first();
                                
                            if ($existingOtherSession) {
                                $mapelName = $item->mapel->nama ?? 'Unknown';
                                $time = $existingOtherSession->jadwalSesi;
                                \Filament\Notifications\Notification::make()
                                    ->title("Gagal Menambahkan Mapel: {$mapelName}")
                                    ->body("Mapel {$mapelName} sudah terkunci pada Sesi Jam {$time->jam_mulai} selama {$semester}.")
                                    ->danger()
                                    ->send();
                                continue;
                            }
                            
                            $exactDuplicate = SesiKelas::where('pengajaran_id', $pengajaranId)
                                ->where('jadwal_sesi_id', $jadwalSesiId)
                                ->where('tanggal', $tanggal)
                                ->exists();

                            if (!$exactDuplicate) {
                                SesiKelas::create([
                                    'jadwal_sesi_id' => $jadwalSesiId,
                                    'pengajaran_id' => $pengajaranId,
                                    'tanggal' => $tanggal,
                                    'semester' => $semester,
                                ]);
                                $successCount++;
                            }
                        }
                        
                        if ($successCount > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title("{$successCount} Jadwal Mapel berhasil ditambahkan ke sesi.")
                                ->success()
                                ->send();
                        }
                    }),
                ViewAction::make(),
            ]);
    }

}
