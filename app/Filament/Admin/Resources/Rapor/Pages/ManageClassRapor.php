<?php

namespace App\Filament\Admin\Resources\Rapor\Pages;

use App\Filament\Admin\Resources\Rapor\RaporResource;
use App\Models\Kelas;
use App\Models\Pengajaran;
use App\Models\Rapor;
use App\Models\Siswa;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Attributes\Url;

class ManageClassRapor extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = RaporResource::class;

    protected string $view = 'filament.resources.rapor.pages.manage-class-rapor';

    public Kelas $record;

    #[Url]
    public string $semester = '1';

    public function mount(Kelas $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return "Rapor Kelas: {$this->record->nama_kelas}";
    }

    public function getSubheading(): ?string
    {
        $label = $this->semester === '1' ? 'Semester 1 (Ganjil)' : 'Semester 2 (Genap)';
        return "Pilih siswa untuk input nilai rapor — {$label}";
    }

    public function getMaxContentWidth(): string
    {
        return 'full';
    }

    public function setSemester(string $value): void
    {
        $this->semester = $value;
        $this->resetTable();
    }

    public function table(Table $table): Table
    {
        $kelasId = $this->record->id;
        $semester = $this->semester;
        $totalPengajaran = Pengajaran::where('kelas_id', $kelasId)->count();

        return $table
            ->query(
                Siswa::query()
                    ->where('kelas_id', $kelasId)
                    ->with([
                        'rapor' => fn ($q) => $q->where('semester', $semester)
                            ->whereHas('pengajaran', fn ($inner) => $inner->where('kelas_id', $kelasId))
                    ])
            )
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('rapor_status')
                    ->label('Status Rapor')
                    ->badge()
                    ->state(function (Siswa $siswa) use ($totalPengajaran) {
                        $filled = $siswa->rapor->count();

                        if ($filled === 0) return 'Belum Diisi';
                        if ($filled >= $totalPengajaran) return 'Lengkap ✓';
                        return "{$filled}/{$totalPengajaran} Mapel";
                    })
                    ->color(fn (string $state) => match (true) {
                        str_contains($state, 'Lengkap') => 'success',
                        $state === 'Belum Diisi'        => 'danger',
                        default                         => 'warning',
                    }),

                TextColumn::make('rata_rata')
                    ->label('Rata-rata')
                    ->state(function (Siswa $siswa) {
                        $avg = $siswa->rapor->avg('nilai');
                        return $avg ? number_format($avg, 1) : '-';
                    })
                    ->badge()
                    ->color(fn (string $state) => match (true) {
                        $state === '-'              => 'gray',
                        (float) $state >= 90        => 'success',
                        (float) $state >= 80        => 'info',
                        (float) $state >= 70        => 'warning',
                        default                     => 'danger',
                    }),
            ])
            ->recordActions([
                Action::make('input_nilai')
                    ->label('Input Nilai')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->url(fn (Siswa $siswa) => RaporResource::getUrl('input', [
                        'record'   => $this->record,
                        'siswa'    => $siswa,
                        'semester' => $this->semester,
                    ])),
                Action::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (Siswa $siswa) => route('rapor.pdf', [
                        'siswa'    => $siswa,
                        'semester' => $this->semester,
                    ]))
                    ->openUrlInNewTab(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Daftar Kelas')
                ->color('gray')
                ->outlined()
                ->icon('heroicon-m-arrow-left')
                ->url(RaporResource::getUrl('index')),
        ];
    }
}
