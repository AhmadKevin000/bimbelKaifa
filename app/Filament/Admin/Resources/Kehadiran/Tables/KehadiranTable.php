<?php

namespace App\Filament\Admin\Resources\Kehadiran\Tables;

use App\Models\SesiKelas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class KehadiranTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            ->defaultGroup(
                Group::make('tanggal')
                    ->label('Tanggal')
                    ->collapsible()
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn (SesiKelas $record): string =>
                        $record->tanggal ? $record->tanggal->format('d M Y') : 'Tanpa Tanggal'
                    )
                    ->getKeyFromRecordUsing(fn (SesiKelas $record): string =>
                        $record->tanggal ? $record->tanggal->format('Y-m-d') : '0000-00-00'
                    )
            )
            ->groupingSettingsHidden()
            ->columns([
                TextColumn::make('kelas_name')
                    ->label('Kelas')
                    ->getStateUsing(fn (SesiKelas $record) => $record->kelas_name_snapshot ?? $record->pengajaran?->kelas?->nama_kelas ?? '-')
                    ->searchable(query: function ($query, string $search) {
                        $query->where('kelas_name_snapshot', 'like', "%{$search}%")
                              ->orWhereHas('pengajaran.kelas', fn($q) => $q->where('nama_kelas', 'like', "%{$search}%"));
                    })
                    ->weight('bold')
                    ->icon('heroicon-o-academic-cap')
                    ->color('primary'),
                TextColumn::make('guru_name')
                    ->label('Guru')
                    ->getStateUsing(fn (SesiKelas $record) => $record->guru_name_snapshot ?? $record->pengajaran?->guru?->nama ?? '-')
                    ->searchable(query: function ($query, string $search) {
                        $query->where('guru_name_snapshot', 'like', "%{$search}%")
                              ->orWhereHas('pengajaran.guru', fn($q) => $q->where('nama', 'like', "%{$search}%"));
                    })
                    ->icon('heroicon-o-user'),
                TextColumn::make('mapel_name')
                    ->label('Mata Pelajaran')
                    ->getStateUsing(fn (SesiKelas $record) => $record->mapel_name_snapshot ?? $record->pengajaran?->mapel?->nama ?? '-')
                    ->searchable(query: function ($query, string $search) {
                        $query->where('mapel_name_snapshot', 'like', "%{$search}%")
                              ->orWhereHas('pengajaran.mapel', fn($q) => $q->where('nama', 'like', "%{$search}%"));
                    }),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar'),
                TextColumn::make('jadwalSesi.jam_mulai')
                    ->label('Jam Mulai')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('H:i') : '-'),
                TextColumn::make('jadwalSesi.jam_selesai')
                    ->label('Jam Selesai')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('H:i') : '-'),
                TextColumn::make('status_kehadiran')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(function (SesiKelas $record): string {
                        $absensi = $record->absensiGuru;

                        if (!$absensi) {
                            return 'Belum Check-In';
                        }

                        if ($absensi->status === 'selesai') {
                            return 'Selesai';
                        }

                        // Status ongoing — cek apakah semua siswa sudah diabsen
                        $totalSiswa = $record->pengajaran?->kelas?->siswa?->count() ?? 0;
                        $totalAbsensi = $record->absensiSiswa->count();

                        if ($totalSiswa > 0 && $totalAbsensi >= $totalSiswa) {
                            return 'Menunggu Check-Out';
                        }

                        return 'Sedang Berlangsung';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Check-In' => 'gray',
                        'Sedang Berlangsung' => 'warning',
                        'Menunggu Check-Out' => 'info',
                        'Selesai' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->label('Detail'),
            ]);
    }
}
