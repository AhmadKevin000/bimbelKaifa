<?php

namespace App\Filament\Guru\Widgets;

use App\Models\SesiKelas;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class MySessionsWidget extends Widget
{
    protected string $view = 'filament.guru.widgets.my-sessions-widget';
    protected static bool $isLazy = false;
    protected int | string | array $columnSpan = 'full';

    public ?string $filterStatus = '';
    public ?string $filterSemester = '';

    private function getGuruId(): int
    {
        return auth()->user()->guru->id;
    }

    public function getSesiList(): Collection
    {
        return SesiKelas::whereHas('pengajaran', function ($query) {
                $query->where('guru_id', $this->getGuruId());
            })
            ->with([
                'pengajaran.mapel.jenjang',
                'pengajaran.kelas',
                'jadwalSesi',
                'absensiGuru',
            ])
            ->when($this->filterSemester, fn($q) =>
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
        return SesiKelas::whereHas('pengajaran', fn($q) =>
            $q->where('guru_id', $this->getGuruId())
        )
        ->select('semester')
        ->distinct()
        ->orderBy('semester')
        ->pluck('semester');
    }

    public function getStats(): array
    {
        $guruId = $this->getGuruId();

        $all = SesiKelas::whereHas('pengajaran', fn($q) =>
            $q->where('guru_id', $guruId)
        )->with('absensiGuru')->get();

        $total    = $all->count();
        $hadir    = $all->filter(fn($s) => optional($s->absensiGuru)->status === 'hadir')->count();
        $absen    = $all->filter(fn($s) => optional($s->absensiGuru)->status === 'absen')->count();
        $belum    = $all->filter(fn($s) => is_null($s->absensiGuru))->count();

        return compact('total', 'hadir', 'absen', 'belum');
    }
}
