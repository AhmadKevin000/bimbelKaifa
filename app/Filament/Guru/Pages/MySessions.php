<?php

namespace App\Filament\Guru\Pages;

use App\Models\SesiKelas;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class MySessions extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Sesi Saya';
    protected static ?string $title = 'Sesi Saya';
    protected static ?string $slug = 'my-sessions';
    protected static ?int $navigationSort = 7;
    protected string $view = 'filament.guru.pages.my-sessions';

    public ?string $filterStatus = '';
    public ?string $filterSemester = '';

    public function getGuruId(): int
    {
        return auth()->user()->guru->id;
    }

    public function getSesiList(): Collection
    {
        return SesiKelas::where(function ($query) {
            $query->whereHas('pengajaran', fn($q) => $q->where('guru_id', $this->getGuruId()))
                ->orWhereHas('absensiGuru', fn($q) => $q->where('guru_id', $this->getGuruId()));
        })
            ->with([
                'pengajaran.mapel.jenjang',
                'pengajaran.kelas',
                'jadwalSesi',
                'absensiGuru',
            ])
            ->when(
                $this->filterSemester,
                fn($q) =>
                $q->where('semester', $this->filterSemester)
            )
            ->when($this->filterStatus, function ($q) {
                if ($this->filterStatus === 'hadir') {
                    $q->whereHas('absensiGuru', fn($q2) => $q2->where('status', 'hadir'));
                } elseif ($this->filterStatus === 'absen') {
                    $q->whereHas('absensiGuru', fn($q2) => $q2->where('status', 'absen'));
                } elseif ($this->filterStatus === 'belum') {
                    $q->whereDoesntHave('absensiGuru');
                }
            })
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function getSemesterList(): Collection
    {
        return SesiKelas::where(function ($query) {
            $query->whereHas('pengajaran', fn($q) => $q->where('guru_id', $this->getGuruId()))
                ->orWhereHas('absensiGuru', fn($q) => $q->where('guru_id', $this->getGuruId()));
        })
            ->select('semester')
            ->distinct()
            ->orderBy('semester')
            ->pluck('semester');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Guru\Widgets\MySessionsWidget::class,
        ];
    }
}
