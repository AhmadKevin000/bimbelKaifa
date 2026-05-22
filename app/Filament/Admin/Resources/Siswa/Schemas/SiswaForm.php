<?php

namespace App\Filament\Admin\Resources\Siswa\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Services\FinanceService;
use App\Models\Kelas;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ── Section 1: Informasi Pribadi & Akademik ───────────────
                Section::make('Informasi Siswa')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->columnSpanFull(),
                        DatePicker::make('tanggal_lahir')
                            ->required(),
                        TextInput::make('no_hp')
                            ->required(),
                        Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('jenjang')
                            ->options(fn () => \App\Models\Jenjang::pluck('nama', 'nama'))
                            ->required()
                            ->live()
                            ->dehydrated(false)
                            ->afterStateUpdated(function (Set $set) {
                                $set('program', null);
                                $set('jumlah_mapel', null);
                            }),

                        Select::make('program')
                            ->options(fn (Get $get) => \App\Models\Program::pluck('nama', 'nama'))
                            ->required()
                            ->disabled(fn (Get $get) => !$get('jenjang'))
                            ->live()
                            ->dehydrated(false)
                            ->afterStateUpdated(fn (Set $set) => $set('jumlah_mapel', null)),

                        TextInput::make('jumlah_mapel')
                            ->label('Jumlah Mata Pelajaran')
                            ->numeric()
                            ->minValue(1)
                            ->required(fn (Get $get) => $get('jenjang') === 'SMA')
                            ->visible(fn (Get $get) => $get('jenjang') === 'SMA')
                            ->live(),

                        Select::make('kelas_id')
                            ->relationship('kelas', 'nama_kelas')
                            ->searchable()
                            ->preload()
                            ->live(),

                        DatePicker::make('tanggal_daftar')
                            ->required(),

                        Placeholder::make('finance_preview')
                            ->label('Rincian Biaya')
                            ->columnSpanFull()
                            ->content(function (Get $get) {
                                $program     = $get('program');
                                $jenjang     = $get('jenjang');
                                $kelasId     = $get('kelas_id');
                                $jumlahMapel = (int) $get('jumlah_mapel');

                                if (!$program || !$jenjang) {
                                    return 'Pilih jenjang dan program untuk melihat rincian biaya.';
                                }
                                if ($jenjang === 'SMA' && !$jumlahMapel) {
                                    return 'Masukkan jumlah mata pelajaran untuk SMA.';
                                }

                                $financeService = new FinanceService();
                                $subjectCount   = $jumlahMapel;

                                if ($jenjang !== 'SMA' && $kelasId) {
                                    $kelas        = Kelas::find($kelasId);
                                    $subjectCount = $kelas ? $kelas->pengajaran()->count() : 0;
                                }

                                $spp          = $financeService->calculateSpp($program, $jenjang, $subjectCount);
                                $registration = $financeService->getRegistrationFee();

                                return sprintf(
                                    "Pendaftaran: Rp %s\nSPP: Rp %s / bulan",
                                    number_format($registration, 0, ',', '.'),
                                    number_format($spp, 0, ',', '.')
                                );
                            }),
                    ]),

                // ── Section 2: Kontak Wali (untuk reminder email SPP) ─────
                Section::make('Kontak Wali')
                    ->description('Informasi ini digunakan untuk mengirim pengingat pembayaran SPP secara otomatis.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama_wali')
                            ->label('Nama Wali / Orang Tua')
                            ->maxLength(100)
                            ->placeholder('Contoh: Bapak Ahmad'),

                        TextInput::make('no_hp')
                            ->label('No. HP Wali')
                            ->tel()
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Gunakan No. HP di atas untuk kontak langsung.')
                            ->columnSpanFull()
                            ->visible(false), // hidden – sudah di section atas

                        TextInput::make('email')
                            ->label('Email Siswa')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('siswa@email.com'),

                        TextInput::make('email_wali')
                            ->label('Email Wali / Orang Tua')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('wali@email.com')
                            ->helperText('Email ini yang akan menerima notifikasi pengingat SPP.'),
                    ]),
            ]);
    }
}

