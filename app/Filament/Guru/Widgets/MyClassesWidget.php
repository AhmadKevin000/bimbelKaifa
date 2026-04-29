<?php

namespace App\Filament\Guru\Widgets;

use App\Models\Kelas;
use App\Models\Mapel;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class MyClassesWidget extends Widget
{
    protected string $view = 'filament.guru.widgets.my-classes-widget';
    protected static bool $isLazy = false;
    protected int | string | array $columnSpan = 'full';

    public ?string $filterMapel = '';

    public function getKelas(): Collection
    {
        $guruId = auth()->user()->guru->id;

        return Kelas::whereHas('pengajaran', fn($q) => $q->where('guru_id', $guruId))
            ->with([
                'pengajaran' => fn($q) => $q
                    ->where('guru_id', $guruId)
                    ->with(['mapel.jenjang']),
                'siswa',
            ])
            ->when($this->filterMapel, fn($q) =>
                $q->whereHas('pengajaran.mapel', fn($q2) =>
                    $q2->where('id', $this->filterMapel)
                )
            )
            ->get();
    }

    public function getMapelList(): Collection
    {
        $guruId = auth()->user()->guru->id;
        return Mapel::whereHas('pengajaran', fn($q) =>
            $q->where('guru_id', $guruId)
        )->get();
    }
}