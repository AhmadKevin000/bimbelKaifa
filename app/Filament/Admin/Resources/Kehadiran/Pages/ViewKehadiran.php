<?php

namespace App\Filament\Admin\Resources\Kehadiran\Pages;

use App\Filament\Admin\Resources\Kehadiran\KehadiranResource;
use App\Models\AbsensiGuru;
use App\Models\AbsensiSiswa;
use App\Models\SesiKelas;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;

class ViewKehadiran extends ViewRecord
{
    protected static string $resource = KehadiranResource::class;

    protected function getHeaderActions(): array
    {
        /** @var SesiKelas $record */
        $record = $this->getRecord();

        return [
            // ── CHECK-IN ──
            \Filament\Actions\Action::make('check_in')
                ->label('Check-In Guru')
                ->icon('heroicon-o-arrow-right-start-on-rectangle')
                ->color('success')
                ->visible(fn () => !$record->absensiGuru)
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Check-In')
                ->modalDescription('Guru akan di-check-in untuk sesi ini. Lanjutkan?')
                ->action(function () use ($record) {
                    $pengajaran = $record->pengajaran;

                    AbsensiGuru::create([
                        'sesi_kelas_id' => $record->id,
                        'guru_id'       => $pengajaran?->guru_id,
                        'kelas_id'      => $pengajaran?->kelas_id,
                        'mapel_id'      => $pengajaran?->mapel_id,
                        'check_in'      => now(),
                        'status'        => 'ongoing',
                    ]);

                    Notification::make()
                        ->title('Check-In Berhasil')
                        ->body('Guru telah check-in. Silakan input absensi siswa.')
                        ->success()
                        ->send();

                    $this->refreshFormData(['absensiGuru', 'absensiSiswa']);
                    $this->redirect(KehadiranResource::getUrl('view', ['record' => $record]));
                }),

            // ── CHECK-OUT ──
            \Filament\Actions\Action::make('check_out')
                ->label('Check-Out Guru')
                ->icon('heroicon-o-arrow-right-end-on-rectangle')
                ->color('danger')
                ->visible(fn () => $record->absensiGuru && $record->absensiGuru->status === 'ongoing')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Check-Out')
                ->modalDescription('Pastikan absensi siswa sudah diisi. Sesi akan ditandai selesai dan gaji akan dihitung otomatis.')
                ->action(function () use ($record) {
                    $absensiGuru = $record->absensiGuru;

                    // Validasi absensi siswa sudah diisi
                    if (!$record->absensiSiswa()->exists()) {
                        Notification::make()
                            ->title('Gagal Check-Out')
                            ->body('Absensi siswa belum diisi! Silakan input absensi siswa terlebih dahulu.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $absensiGuru->update([
                        'check_out' => now(),
                        'status'    => 'selesai',
                    ]);
                    // Observer AbsensiGuru akan otomatis menghitung gaji & cashflow

                    Notification::make()
                        ->title('Check-Out Berhasil')
                        ->body('Sesi selesai. Gaji guru telah dihitung otomatis.')
                        ->success()
                        ->send();

                    $this->redirect(KehadiranResource::getUrl('view', ['record' => $record]));
                }),

            // ── INPUT ABSENSI SISWA ──
            \Filament\Actions\Action::make('input_absensi_siswa')
                ->label('Input Absensi Siswa')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->visible(fn () => $record->absensiGuru
                    && $record->absensiGuru->status === 'ongoing')
                ->form(function () use ($record) {
                    $students = $record->pengajaran?->kelas?->siswa ?? collect();

                    if ($students->isEmpty()) {
                        return [
                            \Filament\Forms\Components\Placeholder::make('no_students')
                                ->label('')
                                ->content('Tidak ada siswa terdaftar di kelas ini.'),
                        ];
                    }

                    // Ambil data absensi yang sudah ada
                    $existingAbsensi = $record->absensiSiswa()
                        ->pluck('status', 'siswa_id')
                        ->toArray();

                    $fields = [];
                    foreach ($students as $siswa) {
                        $default = $existingAbsensi[$siswa->id] ?? 'hadir';
                        $fields[] = \Filament\Forms\Components\Select::make("siswa_{$siswa->id}")
                            ->label($siswa->nama)
                            ->options([
                                'hadir' => '✅ Hadir',
                                'izin'  => '📋 Izin',
                                'sakit' => '🏥 Sakit',
                                'alpha' => '❌ Alpha',
                            ])
                            ->default($default)
                            ->required();
                    }

                    return $fields;
                })
                ->modalHeading('Input Absensi Siswa')
                ->modalDescription('Pilih status kehadiran untuk setiap siswa.')
                ->modalSubmitActionLabel('Simpan Absensi')
                ->action(function (array $data) use ($record) {
                    $students = $record->pengajaran?->kelas?->siswa ?? collect();

                    // Hapus data absensi lama lalu buat ulang
                    $record->absensiSiswa()->delete();

                    foreach ($students as $siswa) {
                        $status = $data["siswa_{$siswa->id}"] ?? 'alpha';
                        AbsensiSiswa::create([
                            'sesi_kelas_id' => $record->id,
                            'siswa_id'      => $siswa->id,
                            'status'        => $status,
                        ]);
                    }

                    Notification::make()
                        ->title('Absensi Siswa Berhasil Disimpan')
                        ->success()
                        ->send();

                    $this->redirect(KehadiranResource::getUrl('view', ['record' => $record]));
                }),
        ];
    }

    public function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                // ═══════════════════════════════════════
                // SECTION 1: INFORMASI KEHADIRAN GURU
                // ═══════════════════════════════════════
                Section::make('Informasi Kehadiran Guru')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextEntry::make('pengajaran.guru.nama')
                            ->label('Guru'),
                        TextEntry::make('pengajaran.mapel.nama')
                            ->label('Mata Pelajaran'),
                        TextEntry::make('pengajaran.kelas.nama_kelas')
                            ->label('Kelas'),
                        TextEntry::make('tanggal')
                            ->label('Tanggal')
                            ->date(),
                        TextEntry::make('jadwalSesi.jam_mulai')
                            ->label('Jam Mulai'),
                        TextEntry::make('jadwalSesi.jam_selesai')
                            ->label('Jam Selesai'),
                        TextEntry::make('absensiGuru.check_in')
                            ->label('Check In')
                            ->dateTime('H:i:s, d M Y')
                            ->placeholder('Belum Check-In'),
                        TextEntry::make('absensiGuru.check_out')
                            ->label('Check Out')
                            ->dateTime('H:i:s, d M Y')
                            ->placeholder('Belum Check-Out'),
                        TextEntry::make('status_kehadiran_guru')
                            ->label('Status')
                            ->badge()
                            ->getStateUsing(function ($record): string {
                                $absensi = $record->absensiGuru;
                                if (!$absensi) return 'Belum Check-In';
                                if ($absensi->status === 'selesai') return 'Selesai';

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
                    ])->columns(3),

                // ═══════════════════════════════════════
                // SECTION 2: ABSENSI SISWA
                // ═══════════════════════════════════════

                // — Pesan jika guru belum check-in
                Section::make('Absensi Siswa')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('notice')
                            ->label('')
                            ->getStateUsing(fn () => 'Guru harus check-in terlebih dahulu sebelum absensi siswa dapat dilakukan.')
                            ->color('warning')
                            ->icon('heroicon-o-exclamation-triangle'),
                    ])
                    ->visible(fn ($record) => !$record->absensiGuru),

                // — Tabel absensi siswa (sudah ada data)
                Section::make('Absensi Siswa')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        \Filament\Infolists\Components\RepeatableEntry::make('absensiSiswa')
                            ->label('')
                            ->schema([
                                TextEntry::make('siswa.nama')
                                    ->label('Nama Siswa'),
                                TextEntry::make('status')
                                    ->label('Status Kehadiran')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => match (strtolower($state)) {
                                        'hadir' => 'Hadir',
                                        'izin' => 'Izin',
                                        'sakit' => 'Sakit',
                                        'alpha' => 'Alpha',
                                        default => ucfirst($state),
                                    })
                                    ->color(fn (string $state): string => match (strtolower($state)) {
                                        'hadir' => 'success',
                                        'izin' => 'warning',
                                        'sakit' => 'info',
                                        'alpha' => 'danger',
                                        default => 'gray',
                                    }),
                            ])
                            ->columns(2),
                    ])
                    ->visible(fn ($record) => $record->absensiGuru && $record->absensiSiswa()->exists()),

                // — Pesan jika guru sudah check-in tapi belum ada absensi siswa
                Section::make('Absensi Siswa')
                    ->icon('heroicon-o-user-group')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('notice_empty')
                            ->label('')
                            ->getStateUsing(fn () => 'Absensi siswa belum diisi. Klik tombol "Input Absensi Siswa" di atas untuk mengisi.')
                            ->color('info')
                            ->icon('heroicon-o-information-circle'),
                    ])
                    ->visible(fn ($record) => $record->absensiGuru
                        && $record->absensiGuru->status === 'ongoing'
                        && !$record->absensiSiswa()->exists()),

                // ═══════════════════════════════════════
                // SECTION 3: INFO GAJI (hanya jika selesai)
                // ═══════════════════════════════════════
                Section::make('Informasi Gaji')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        TextEntry::make('absensiGuru.penggajian.nominal')
                            ->label('Gaji Sesi')
                            ->money('IDR')
                            ->placeholder('Belum dihitung'),
                        TextEntry::make('absensiGuru.penggajian.status_pembayaran')
                            ->label('Status Pembayaran')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'paid' => 'success',
                                default => 'warning',
                            }),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => $record->absensiGuru?->status === 'selesai'),
            ]);
    }
}
