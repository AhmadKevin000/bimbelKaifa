<?php

namespace App\Filament\Guru\Pages;

use App\Models\Guru;
use App\Models\Penggajian;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GajiPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected string $view = 'filament.guru.pages.gaji-page';

    protected static ?string $title           = 'Riwayat Gaji';
    protected static ?string $navigationLabel = 'Gaji';
    protected static ?int    $navigationSort  = 3;

    public string $filterTahun = '';

    public function mount(): void
    {
        $this->filterTahun = (string) now()->year;
    }

    // ── Guru yang sedang login ─────────────────────────────────────────────
    protected function getGuru(): ?Guru
    {
        return Guru::where('user_id', auth()->id())->first();
    }

    // ── Table ──────────────────────────────────────────────────────────────
    public function table(Table $table): Table
    {
        $guru = $this->getGuru();

        return $table
            ->query(
                Penggajian::query()
                    ->with([
                        'absensiGuru.sesiKelas.jadwalSesi',
                        'absensiGuru.kelasSnapshot',
                        'absensiGuru.mapel',
                        'tarifGaji',
                    ])
                    ->when($guru, fn(Builder $q) =>
                        $q->where('guru_id', $guru->id)
                    )
                    ->when($this->filterTahun, fn(Builder $q) =>
                        $q->where(function (Builder $inner) {
                            $inner->whereYear('tanggal_pembayaran', $this->filterTahun)
                                  ->orWhereNull('tanggal_pembayaran');
                        })
                    )
                    ->orderByDesc('tanggal_pembayaran')
                    ->orderByDesc('created_at')
            )
            ->columns([
                TextColumn::make('absensiGuru.sesiKelas.tanggal')
                    ->label('Tanggal Sesi')
                    ->date('d M Y')
                    ->default('-')
                    ->sortable(),

                TextColumn::make('absensiGuru.sesiKelas.jadwalSesi.nama')
                    ->label('Sesi')
                    ->default('-'),

                TextColumn::make('absensiGuru.kelasSnapshot.nama_kelas')
                    ->label('Kelas')
                    ->badge()
                    ->color('primary')
                    ->default('-'),

                TextColumn::make('absensiGuru.mapel.nama')
                    ->label('Mata Pelajaran')
                    ->default('-'),

                TextColumn::make('rate_snapshot')
                    ->label('Rate (Rp/sesi)')
                    ->numeric()
                    ->prefix('Rp ')
                    ->formatStateUsing(fn($state) => number_format((float)($state ?? 0), 0, ',', '.'))
                    ->default('-'),

                TextColumn::make('nominal')
                    ->label('Nominal Gaji')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format((float)($state ?? 0), 0, ',', '.'))
                    ->weight('bold')
                    ->color(fn($record) => $record->status_pembayaran === 'paid' ? 'success' : 'warning'),

                TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal Bayar')
                    ->date('d M Y')
                    ->default('Belum dibayar')
                    ->sortable(),

                TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'paid'    => 'Dibayar',
                        'pending' => 'Pending',
                        default   => ucfirst($state ?? '-'),
                    })
                    ->color(fn($state) => match($state) {
                        'paid'    => 'success',
                        'pending' => 'warning',
                        default   => 'gray',
                    }),
            ])
            ->actions([
                \Filament\Actions\Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Penggajian Sesi')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->infolist([
                        \Filament\Schemas\Components\Section::make('Informasi Sesi & Kelas')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('absensiGuru.sesiKelas.tanggal')
                                    ->label('Tanggal Sesi')
                                    ->date('d M Y'),
                                \Filament\Infolists\Components\TextEntry::make('absensiGuru.sesiKelas.jadwalSesi.nama')
                                    ->label('Nama Sesi')
                                    ->state(fn ($record) => 
                                        ($record->absensiGuru?->sesiKelas?->jadwalSesi?->nama ?? '-') . 
                                        ' (' . 
                                        substr($record->absensiGuru?->sesiKelas?->jadwalSesi?->jam_mulai ?? '', 0, 5) . 
                                        ' - ' . 
                                        substr($record->absensiGuru?->sesiKelas?->jadwalSesi?->jam_selesai ?? '', 0, 5) . 
                                        ')'
                                    ),
                                \Filament\Infolists\Components\TextEntry::make('absensiGuru.kelasSnapshot.nama_kelas')
                                    ->label('Kelas')
                                    ->badge()
                                    ->color('primary')
                                    ->state(fn ($record) => 
                                        $record->absensiGuru?->kelas_name_snapshot ?? $record->absensiGuru?->kelasSnapshot?->nama_kelas ?? '-'
                                    ),
                                \Filament\Infolists\Components\TextEntry::make('absensiGuru.mapel.nama')
                                    ->label('Mata Pelajaran')
                                    ->state(fn ($record) => 
                                        $record->absensiGuru?->mapel_name_snapshot ?? $record->absensiGuru?->mapel?->nama ?? '-'
                                    ),
                            ])->columns(2),

                        \Filament\Schemas\Components\Section::make('Informasi Kehadiran & Tarif')
                            ->icon('heroicon-o-users')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('absensiGuru.jumlah_siswa_hadir')
                                    ->label('Siswa Hadir')
                                    ->badge()
                                    ->color('success')
                                    ->state(fn ($record) => 
                                        $record->absensiGuru?->jumlah_siswa_hadir ?? 0
                                    ),
                                \Filament\Infolists\Components\TextEntry::make('siswa_absen')
                                    ->label('Siswa Absen (Izin/Sakit/Alfa)')
                                    ->badge()
                                    ->color('danger')
                                    ->state(fn ($record) => 
                                        $record->absensiGuru?->absensiSiswa()
                                            ->whereIn('status', ['izin', 'sakit', 'alfa'])
                                            ->count() ?? 0
                                    ),
                                \Filament\Infolists\Components\TextEntry::make('rate_snapshot')
                                    ->label('Tarif Dasar')
                                    ->money('IDR'),
                                \Filament\Infolists\Components\TextEntry::make('perhitungan')
                                    ->label('Perhitungan Gaji')
                                    ->state(fn ($record) => 
                                        strtoupper($record->absensiGuru?->mapel?->program?->nama ?? '') === 'CALISTUNG'
                                            ? 'Calistung (Siswa Hadir x Tarif Dasar)'
                                            : 'Reguler/Flat (Tarif Dasar)'
                                    ),
                            ])->columns(2),

                        \Filament\Schemas\Components\Section::make('Status Pembayaran')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('nominal')
                                    ->label('Total Gaji Sesi')
                                    ->money('IDR')
                                    ->weight('bold')
                                    ->color('success'),
                                \Filament\Infolists\Components\TextEntry::make('tanggal_pembayaran')
                                    ->label('Tanggal Pembayaran')
                                    ->date('d M Y')
                                    ->placeholder('Belum dibayar'),
                                \Filament\Infolists\Components\TextEntry::make('status_pembayaran')
                                    ->label('Status')
                                    ->badge()
                                    ->formatStateUsing(fn($state) => match($state) {
                                        'paid'    => 'Dibayar',
                                        'pending' => 'Pending',
                                        default   => ucfirst($state ?? '-'),
                                    })
                                    ->color(fn($state) => match($state) {
                                        'paid'    => 'success',
                                        'pending' => 'warning',
                                        default   => 'gray',
                                    }),
                            ])->columns(3),
                    ])
            ])
            ->defaultSort('tanggal_pembayaran', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->emptyStateHeading('Belum ada data gaji')
            ->emptyStateDescription('Data gaji akan muncul setelah sesi mengajar terverifikasi.')
            ->emptyStateIcon('heroicon-o-banknotes');
    }

    // ── Data untuk view 
    public function getViewData(): array
    {
        $guru = $this->getGuru();

        $totalDiterima = 0;
        $totalPending  = 0;
        $totalSesi     = 0;
        $tahunTersedia = collect();

        if ($guru) {
            $totalDiterima = Penggajian::where('guru_id', $guru->id)
                ->where('status_pembayaran', 'paid')
                ->when($this->filterTahun, fn($q) => $q->whereYear('tanggal_pembayaran', $this->filterTahun))
                ->sum('nominal');

            $totalPending = Penggajian::where('guru_id', $guru->id)
                ->where('status_pembayaran', '!=', 'paid')
                ->sum('nominal');

            $totalSesi = Penggajian::where('guru_id', $guru->id)
                ->when($this->filterTahun, fn($q) =>
                    $q->where(fn($inner) =>
                        $inner->whereYear('tanggal_pembayaran', $this->filterTahun)
                              ->orWhereNull('tanggal_pembayaran')
                    )
                )
                ->count();

            // Tahun yang tersedia dari data penggajian
            $tahunTersedia = Penggajian::where('guru_id', $guru->id)
                ->whereNotNull('tanggal_pembayaran')
                ->selectRaw('YEAR(tanggal_pembayaran) as tahun')
                ->distinct()
                ->orderByDesc('tahun')
                ->pluck('tahun')
                ->filter()
                ->values();

            if ($tahunTersedia->isEmpty()) {
                $tahunTersedia = collect([(int) now()->year]);
            }
        }

        return [
            'namaGuru'      => $guru?->nama ?? auth()->user()->name,
            'totalDiterima' => $totalDiterima,
            'totalPending'  => $totalPending,
            'totalSesi'     => $totalSesi,
            'tahunTersedia' => $tahunTersedia,
            'filterTahun'   => $this->filterTahun,
        ];
    }

    public function setTahun(string $tahun): void
    {
        $this->filterTahun = $tahun;
        $this->resetTable();
    }
}
