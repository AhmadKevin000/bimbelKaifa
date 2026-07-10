<?php

namespace App\Filament\Admin\Resources\Siswa\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AbsensiRelationManager extends RelationManager
{
    protected static string $relationship = 'absensi';

    protected static ?string $title = 'Riwayat Kelas Selesai & Kehadiran';

    protected static ?string $recordTitleAttribute = 'id';

    public function isReadOnly(): bool
    {
        return true;
    }

    protected function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('sesiKelas.absensiGuru', function (Builder $query) {
                $query->where('status', 'selesai');
            });
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sesiKelas.tanggal')
                    ->label('Tanggal Sesi')
                    ->date('d M Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('sesiKelas.jadwalSesi.nama')
                    ->label('Sesi')
                    ->state(fn ($record) => 
                        ($record->sesiKelas?->jadwalSesi?->nama ?? '-') . 
                        ' (' . 
                        substr($record->sesiKelas?->jadwalSesi?->jam_mulai ?? '', 0, 5) . 
                        ' - ' . 
                        substr($record->sesiKelas?->jadwalSesi?->jam_selesai ?? '', 0, 5) . 
                        ')'
                    ),

                Tables\Columns\TextColumn::make('sesiKelas.kelas_name_snapshot')
                    ->label('Kelas')
                    ->badge()
                    ->color('primary')
                    ->state(fn ($record) => 
                        $record->sesiKelas?->kelas_name_snapshot ?? $record->sesiKelas?->kelas?->nama_kelas ?? '-'
                    ),

                Tables\Columns\TextColumn::make('sesiKelas.mapel_name_snapshot')
                    ->label('Mata Pelajaran')
                    ->state(fn ($record) => 
                        $record->sesiKelas?->mapel_name_snapshot ?? $record->sesiKelas?->pengajaran?->mapel?->nama ?? '-'
                    ),

                Tables\Columns\TextColumn::make('sesiKelas.guru_name_snapshot')
                    ->label('Tentor/Guru')
                    ->state(fn ($record) => 
                        $record->sesiKelas?->guru_name_snapshot ?? $record->sesiKelas?->pengajaran?->guru?->nama ?? '-'
                    ),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status Absensi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match (strtolower($state)) {
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha', 'alfa' => 'Alpha',
                        'tidak hadir' => 'Tidak Hadir',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'hadir' => 'success',
                        'izin' => 'warning',
                        'sakit' => 'info',
                        'alpha', 'alfa', 'tidak hadir' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
