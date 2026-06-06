<?php

namespace App\Filament\Admin\Resources\Kehadiran\Tables;

use App\Models\SesiKelas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KehadiranTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            ->columns([
                TextColumn::make('pengajaran.kelas.nama_kelas')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('pengajaran.guru.nama')
                    ->label('Guru')
                    ->searchable(),
                TextColumn::make('pengajaran.mapel.nama')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('jadwalSesi.jam_mulai')
                    ->label('Jam Mulai'),
                TextColumn::make('jadwalSesi.jam_selesai')
                    ->label('Jam Selesai'),
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
