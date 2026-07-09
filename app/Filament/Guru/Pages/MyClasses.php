<?php

namespace App\Filament\Guru\Pages;

use App\Models\Kelas;
use App\Models\Mapel;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class MyClasses extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Kelas';
    protected static ?string $title = 'Kelas Saya';
    protected static ?string $slug = 'my-classes';
    protected static ?int $navigationSort = 6;
    protected string $view = 'filament.guru.pages.my-classes';

    public ?string $filterMapel = '';

    public function getGuruId(): int
    {
        return auth()->user()->guru->id;
    }

    public function getKelas(): Collection
    {
        return Kelas::whereHas('pengajaran', function ($query) {
            $query->where('guru_id', $this->getGuruId());
        })
            ->with([
                'pengajaran' => fn($q) => $q
                    ->where('guru_id', $this->getGuruId())
                    ->with(['mapel.jenjang', 'guru']),
                'siswa',
            ])
            ->when(
                $this->filterMapel,
                fn($query) =>
                $query->whereHas(
                    'pengajaran.mapel',
                    fn($q) =>
                    $q->where('id', $this->filterMapel)
                )
            )
            ->get();
    }

    public function getMapelList(): Collection
    {
        return Mapel::whereHas(
            'pengajaran',
            fn($q) =>
            $q->where('guru_id', $this->getGuruId())
        )->get();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Guru\Widgets\MyClassesWidget::class,
        ];
    }
}