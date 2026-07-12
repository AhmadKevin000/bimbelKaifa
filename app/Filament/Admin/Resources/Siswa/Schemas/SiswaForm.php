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
use App\Models\Pengajaran;
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
                        TextInput::make('email')
                            ->label('Email Siswa')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('siswa@email.com')
                            ->columnSpanFull(),
                        Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('jenjang')
                            ->options(fn() => \App\Models\Jenjang::pluck('nama', 'nama'))
                            ->required()
                            ->live()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($record, $component) {
                                if ($record) {
                                    $jenjang = $record->jenjang;
                                    $component->state(($jenjang === '-') ? null : $jenjang);
                                }
                            })
                            ->afterStateUpdated(function (Set $set) {
                                $set('program', null);
                                $set('jumlah_mapel', null);
                                $set('kelas_id', null);
                                $set('pengajaran_ids', []);
                            }),

                        Select::make('program')
                            ->options(fn(Get $get) => \App\Models\Program::pluck('nama', 'nama'))
                            ->required()
                            ->disabled(fn(Get $get) => !$get('jenjang'))
                            ->live()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($record, $component) {
                                if ($record) {
                                    $program = $record->program;
                                    $component->state(($program === '-') ? null : $program);
                                }
                            })
                            ->afterStateUpdated(fn(Set $set) => $set('jumlah_mapel', null)),

                        // ── Kelas — HANYA untuk SMA ──────────────────────
                        Select::make('kelas_id')
                            ->label('Kelas')
                            ->relationship('kelas', 'nama_kelas')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->visible(fn(Get $get) => $get('jenjang') === 'SMA')
                            ->required(fn(Get $get) => $get('jenjang') === 'SMA')
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($record, $component) {
                                if ($record) {
                                    $component->state($record->kelas_id);
                                }
                            })
                            ->afterStateUpdated(function ($state, Set $set) {
                                // Reset pilihan mapel saat kelas diganti
                                $set('pengajaran_ids', []);
                                $set('jumlah_mapel', null);

                                if (!$state) {
                                    return;
                                }

                                $kelas = Kelas::find($state);
                                if ($kelas) {
                                    $firstTeaching = $kelas->pengajaran()->first();
                                    $program = null;
                                    if ($firstTeaching && $firstTeaching->mapel && $firstTeaching->mapel->program) {
                                        $program = $firstTeaching->mapel->program->nama;
                                    }
                                    $set('program', ($program === '-') ? null : $program);
                                }
                            }),

                        // ── Multi-select Mapel — HANYA untuk SMA & setelah kelas dipilih ──
                        Select::make('pengajaran_ids')
                            ->label('Mapel yang Diikuti')
                            ->multiple()
                            ->live()
                            ->dehydrated(false) // Disimpan manual di CreateSiswa/EditSiswa
                            ->visible(fn(Get $get) => $get('jenjang') === 'SMA' && $get('kelas_id'))
                            ->required(fn(Get $get) => $get('jenjang') === 'SMA' && $get('kelas_id'))
                            ->columnSpanFull()
                            ->options(function (Get $get) {
                                $kelasId = $get('kelas_id');
                                if (!$kelasId) return [];

                                return Pengajaran::where('kelas_id', $kelasId)
                                    ->with('mapel')
                                    ->get()
                                    ->mapWithKeys(function ($p) {
                                        $maxInfo = $p->max_siswa
                                            ? " (Maks. {$p->max_siswa} siswa)"
                                            : '';
                                        $terisi = $p->siswa()->count();
                                        $label = ($p->mapel->nama ?? 'Unknown') . " [{$terisi}" . ($p->max_siswa ? "/{$p->max_siswa}" : "") . " siswa]{$maxInfo}";
                                        return [$p->id => $label];
                                    });
                            })
                            ->afterStateHydrated(function ($record, $component) {
                                // Hydrate pilihan mapel saat edit siswa SMA
                                if ($record && $record->kelas_id) {
                                    $ids = $record->pengajaranEnrolled()
                                        ->pluck('pengajaran.id')
                                        ->toArray();
                                    $component->state($ids);
                                }
                            })
                            ->afterStateUpdated(function ($state, Set $set) {
                                // Auto-update jumlah_mapel sesuai jumlah yang dipilih
                                $set('jumlah_mapel', count($state ?? []));
                            })
                            ->helperText('Pilih mapel yang akan diikuti siswa ini. Jumlah mapel akan terupdate otomatis.'),

                        TextInput::make('jumlah_mapel')
                            ->label('Jumlah Mata Pelajaran')
                            ->numeric()
                            ->minValue(1)
                            ->required(fn(Get $get) => $get('jenjang') === 'SMA')
                            ->visible(fn(Get $get) => $get('jenjang') === 'SMA')
                            ->disabled(fn(Get $get) => $get('jenjang') === 'SMA' && $get('kelas_id'))
                            ->helperText(fn(Get $get) => $get('kelas_id') ? 'Terisi otomatis dari mapel yang dipilih.' : null)
                            ->live(),

                        DatePicker::make('tanggal_daftar')
                            ->required(),

                        Placeholder::make('finance_preview')
                            ->label('Rincian Biaya')
                            ->columnSpanFull()
                            ->content(function (Get $get) {
                                $program = $get('program');
                                $jenjang = $get('jenjang');
                                $kelasId = $get('kelas_id');
                                $jumlahMapel = (int) $get('jumlah_mapel');

                                if (!$program || !$jenjang) {
                                    return 'Pilih jenjang dan program untuk melihat rincian biaya.';
                                }
                                if ($jenjang === 'SMA' && !$jumlahMapel) {
                                    return 'Pilih mapel yang diikuti untuk melihat rincian biaya SMA.';
                                }

                                $financeService = new FinanceService();
                                $subjectCount = $jumlahMapel;

                                if ($jenjang !== 'SMA' && $kelasId) {
                                    $kelas = Kelas::find($kelasId);
                                    $subjectCount = $kelas ? $kelas->pengajaran()->count() : 0;
                                }

                                $spp = $financeService->calculateSpp($program, $jenjang, $subjectCount);
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
