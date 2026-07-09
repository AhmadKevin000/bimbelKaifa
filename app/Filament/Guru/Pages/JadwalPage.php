<?php

namespace App\Filament\Guru\Pages;

use App\Models\Guru;
use App\Models\SesiKelas;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class JadwalPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected string $view = 'filament.guru.pages.jadwal-page';

    protected static ?string $title        = 'Jadwal Mengajar';
    protected static ?string $navigationLabel = 'Jadwal';
    protected static ?int    $navigationSort  = 2;

    // ── Filter bulan/tahun ─────────────────────────────────────────────────
    public string $filterBulan = '';
    public string $filterTahun = '';

    public function mount(): void
    {
        $this->filterBulan = (string) now()->month;
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
                SesiKelas::query()
                    ->with([
                        'jadwalSesi',
                        'pengajaran.kelas',
                        'pengajaran.mapel.jenjang',
                        'pengajaran.mapel.program',
                        'absensiGuru',
                    ])
                    ->when($guru, fn(Builder $q) =>
                        $q->where(fn(Builder $query) =>
                            $query->whereHas('pengajaran', fn(Builder $inner) => $inner->where('guru_id', $guru->id))
                                  ->orWhereHas('absensiGuru', fn(Builder $inner) => $inner->where('guru_id', $guru->id))
                        )
                    )
                    ->when($this->filterBulan, fn(Builder $q) =>
                        $q->whereMonth('tanggal', $this->filterBulan)
                    )
                    ->when($this->filterTahun, fn(Builder $q) =>
                        $q->whereYear('tanggal', $this->filterTahun)
                    )
                    ->orderBy('tanggal')
                    ->orderByRaw('(SELECT jam_mulai FROM jadwal_sesi WHERE jadwal_sesi.id = sesi_kelas.jadwal_sesi_id) ASC')
            )
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('l, d M Y')
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('jadwalSesi.nama')
                    ->label('Sesi')
                    ->default('-'),

                TextColumn::make('jadwalSesi.jam_mulai')
                    ->label('Jam Mulai')
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('H:i') : '-'),

                TextColumn::make('jadwalSesi.jam_selesai')
                    ->label('Jam Selesai')
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('H:i') : '-'),

                TextColumn::make('jadwalSesi.durasi')
                    ->label('Durasi')
                    ->suffix(' menit')
                    ->default('-'),

                TextColumn::make('kelas_name')
                    ->label('Kelas')
                    ->getStateUsing(fn(SesiKelas $record) => $record->kelas_name_snapshot ?? $record->pengajaran?->kelas?->nama_kelas ?? '-')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('mapel_name')
                    ->label('Mata Pelajaran')
                    ->getStateUsing(fn(SesiKelas $record) => $record->mapel_name_snapshot ?? $record->pengajaran?->mapel?->nama ?? '-'),

                TextColumn::make('pengajaran.mapel.jenjang.nama')
                    ->label('Jenjang')
                    ->default('-'),
 
                TextColumn::make('absensiGuru.status')
                    ->label('Status Kehadiran')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'hadir'  => 'Hadir',
                        'izin'   => 'Izin',
                        'sakit'  => 'Sakit',
                        'alpha'  => 'Alpha',
                        null     => 'Belum Absen',
                        default  => ucfirst($state ?? '-'),
                    })
                    ->color(fn($state) => match($state) {
                        'hadir'  => 'success',
                        'izin'   => 'info',
                        'sakit'  => 'warning',
                        'alpha'  => 'danger',
                        null     => 'gray',
                        default  => 'gray',
                    }),
            ])
            ->defaultSort('tanggal', 'asc')
            ->striped()
            ->paginated([10, 25, 50])
            ->emptyStateHeading('Tidak ada jadwal')
            ->emptyStateDescription('Belum ada sesi mengajar untuk periode ini.')
            ->emptyStateIcon('heroicon-o-calendar');
    }

    // ── Data untuk view ───────────────────────────────────────────────────
    public function getViewData(): array
    {
        $guru  = $this->getGuru();

        // Ringkasan bulan ini
        $baseQuery = SesiKelas::query()
            ->when($guru, fn($q) =>
                $q->where(fn($query) =>
                    $query->whereHas('pengajaran', fn($inner) => $inner->where('guru_id', $guru->id))
                          ->orWhereHas('absensiGuru', fn($inner) => $inner->where('guru_id', $guru->id))
                )
            )
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal', $this->filterBulan))
            ->when($this->filterTahun, fn($q) => $q->whereYear('tanggal', $this->filterTahun));

        $totalSesi   = (clone $baseQuery)->count();
        $sudahHadir  = (clone $baseQuery)->whereHas('absensiGuru', fn($q) => $q->where('status', 'hadir'))->count();
        $belumAbsen  = $totalSesi - (clone $baseQuery)->whereHas('absensiGuru')->count();

        // Opsi filter bulan dan tahun
        $opsiTahun = collect(range(now()->year, now()->year - 2))->map(fn($y) => ['value' => $y, 'label' => $y]);
        $opsiBulan = collect([
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November', 12 => 'Desember',
        ])->map(fn($label, $val) => ['value' => $val, 'label' => $label])->values();

        return [
            'namaGuru'    => $guru?->nama ?? auth()->user()->name,
            'totalSesi'   => $totalSesi,
            'sudahHadir'  => $sudahHadir,
            'belumAbsen'  => $belumAbsen,
            'filterBulan' => $this->filterBulan,
            'filterTahun' => $this->filterTahun,
            'opsiTahun'   => $opsiTahun,
            'opsiBulan'   => $opsiBulan,
            'labelBulan'  => [
                1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
                4  => 'April',    5  => 'Mei',       6  => 'Juni',
                7  => 'Juli',     8  => 'Agustus',   9  => 'September',
                10 => 'Oktober',  11 => 'November', 12 => 'Desember',
            ][$this->filterBulan] ?? '',
        ];
    }

    public function setFilter(string $bulan, string $tahun): void
    {
        $this->filterBulan = $bulan;
        $this->filterTahun = $tahun;
        $this->resetTable();
    }
}
