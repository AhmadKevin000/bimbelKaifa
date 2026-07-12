<?php

namespace App\Filament\Admin\Resources\Rapor\Pages;

use App\Filament\Admin\Resources\Rapor\RaporResource;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Rapor;
use App\Models\Pengajaran;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Livewire\Attributes\Computed;

class InputSiswaRapor extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = RaporResource::class;

    protected string $view = 'filament.resources.rapor.pages.input-siswa-rapor';

    public Kelas $record;
    public Siswa $siswa;
    public string $semester;

    public ?array $data = [];

    // Cached pengajaran data for blade view
    public array $pengajaranList = [];

    public function mount(Kelas $record, Siswa $siswa, string $semester): void
    {
        $this->record = $record;
        $this->siswa = $siswa;
        $this->semester = $semester;

        // Cache pengajaran: filter by siswa_pengajaran untuk SMA, fallback ke semua jika non-SMA
        $enrolledIds = $this->siswa->pengajaranEnrolled()
            ->pluck('pengajaran.id');

        $pengajaranQuery = Pengajaran::where('kelas_id', $this->record->id)
            ->with('mapel', 'guru');

        if ($enrolledIds->isNotEmpty()) {
            $pengajaranQuery->whereIn('id', $enrolledIds);
        }

        $this->pengajaranList = $pengajaranQuery->get()
            ->map(fn ($p) => [
                'id'    => $p->id,
                'mapel' => $p->mapel?->nama ?? '-',
                'guru'  => $p->guru?->nama ?? '-',
            ])
            ->toArray();

        $this->form->fill($this->loadGrades());
    }

    public function getTitle(): string
    {
        return "Input Rapor: {$this->siswa->nama}";
    }

    public function getSubheading(): ?string
    {
        $semLabel = $this->semester === '1' ? 'Semester 1 (Ganjil)' : 'Semester 2 (Genap)';
        return "Kelas: {$this->record->nama_kelas} | {$semLabel}";
    }

    public static function getNavigationLabel(): string
    {
        return 'Input Rapor';
    }

    public function getMaxContentWidth(): string
    {
        return 'full';
    }

    protected function loadGrades(): array
    {
        $grades = [];

        $enrolledIds = $this->siswa->pengajaranEnrolled()
            ->pluck('pengajaran.id');

        $pengajaranQuery = Pengajaran::where('kelas_id', $this->record->id);
        if ($enrolledIds->isNotEmpty()) {
            $pengajaranQuery->whereIn('id', $enrolledIds);
        }

        foreach ($pengajaranQuery->get() as $item) {
            $rapor = Rapor::where('siswa_id', $this->siswa->id)
                ->where('pengajaran_id', $item->id)
                ->where('semester', $this->semester)
                ->first();

            $grades["nilai_{$item->id}"] = $rapor?->nilai;
        }

        return $grades;
    }

    public function form(Schema $form): Schema
    {
        $enrolledIds = $this->siswa->pengajaranEnrolled()
            ->pluck('pengajaran.id');

        $pengajaranQuery = Pengajaran::where('kelas_id', $this->record->id)
            ->with('mapel', 'guru');

        if ($enrolledIds->isNotEmpty()) {
            $pengajaranQuery->whereIn('id', $enrolledIds);
        }

        $pengajaran = $pengajaranQuery->get();
        $components = [];

        foreach ($pengajaran as $item) {
            $components[] = TextInput::make("nilai_{$item->id}")
                ->label($item->mapel?->nama ?? 'Unknown')
                ->helperText('Guru: ' . ($item->guru?->nama ?? '-'))
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required()
                ->placeholder('0 - 100')
                ->live(onBlur: true)
                ->extraInputAttributes([
                    'class' => 'nilai-input',
                    'data-pengajaran-id' => $item->id,
                ]);
        }

        return $form
            ->components([
                Section::make('Informasi Siswa')
                    ->icon('heroicon-o-user')
                    ->columns(3)
                    ->compact()
                    ->schema([
                        Placeholder::make('nama_siswa')
                            ->label('Nama Siswa')
                            ->content($this->siswa->nama),
                        Placeholder::make('kelas_info')
                            ->label('Kelas')
                            ->content($this->record->nama_kelas),
                        Placeholder::make('semester_info')
                            ->label('Semester')
                            ->content($this->semester === '1' ? 'Semester 1 (Ganjil)' : 'Semester 2 (Genap)'),
                    ]),

                Section::make('Input Nilai Mata Pelajaran')
                    ->description('Masukkan nilai 0-100 untuk setiap mata pelajaran.')
                    ->icon('heroicon-o-pencil-square')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3, 'xl' => 4])
                    ->schema($components),
            ])
            ->statePath('data');
    }

    /**
     * Get all current nilai values from form state.
     */
    #[Computed]
    public function nilaiSummary(): array
    {
        $values = collect($this->data)
            ->filter(fn ($val, $key) => str_starts_with($key, 'nilai_') && is_numeric($val))
            ->values()
            ->map(fn ($v) => (float) $v);

        $count = $values->count();
        $total = $values->sum();
        $avg   = $count > 0 ? round($total / $count, 1) : 0;

        $predikat = match (true) {
            $avg >= 90 => 'A',
            $avg >= 80 => 'B',
            $avg >= 70 => 'C',
            default    => 'D',
        };

        return [
            'jumlah_mapel' => count($this->pengajaranList),
            'terisi'       => $count,
            'total'        => $total,
            'rata_rata'    => $avg,
            'predikat'     => $predikat,
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $enrolledIds = $this->siswa->pengajaranEnrolled()
            ->pluck('pengajaran.id');

        $pengajaranQuery = Pengajaran::where('kelas_id', $this->record->id);
        if ($enrolledIds->isNotEmpty()) {
            $pengajaranQuery->whereIn('id', $enrolledIds);
        }

        foreach ($pengajaranQuery->get() as $item) {
            $nilaiKey = "nilai_{$item->id}";

            if (isset($state[$nilaiKey]) && is_numeric($state[$nilaiKey])) {
                Rapor::updateOrCreate(
                    [
                        'siswa_id'      => $this->siswa->id,
                        'pengajaran_id' => $item->id,
                        'semester'      => $this->semester,
                    ],
                    [
                        'nilai' => (int) $state[$nilaiKey],
                    ]
                );
            }
        }

        Notification::make()
            ->title('Nilai Berhasil Disimpan')
            ->body("Rapor {$this->siswa->nama} semester {$this->semester} telah tersimpan.")
            ->success()
            ->send();
    }

    public function saveAndNext(): void
    {
        $this->save();

        $nextSiswa = Siswa::where('kelas_id', $this->record->id)
            ->where('id', '>', $this->siswa->id)
            ->orderBy('id', 'asc')
            ->first();

        if ($nextSiswa) {
            $this->redirect(RaporResource::getUrl('input', [
                'record'   => $this->record,
                'siswa'    => $nextSiswa,
                'semester' => $this->semester,
            ]));
        } else {
            Notification::make()
                ->title('Semua siswa di kelas ini telah selesai diinput.')
                ->info()
                ->send();

            $this->redirect(RaporResource::getUrl('manage', ['record' => $this->record]));
        }
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Nilai')
                ->submit('save')
                ->icon('heroicon-o-check-circle')
                ->color('primary'),
            Action::make('saveAndNext')
                ->label('Simpan & Lanjut Siswa Berikutnya')
                ->action('saveAndNext')
                ->icon('heroicon-o-arrow-right')
                ->color('success'),
            Action::make('reset')
                ->label('Reset Form')
                ->color('gray')
                ->outlined()
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->form->fill($this->loadGrades())),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Daftar Siswa')
                ->color('gray')
                ->outlined()
                ->icon('heroicon-m-arrow-left')
                ->url(RaporResource::getUrl('manage', ['record' => $this->record])),
        ];
    }
}
