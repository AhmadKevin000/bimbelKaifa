<?php

namespace App\Filament\Admin\Resources\PaketSoal\Pages;

use App\Filament\Admin\Resources\PaketSoal\PaketSoalResource;
use App\Models\PaketSoal as PaketSoalModel;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewPaketSoal extends ViewRecord
{
    protected static string $resource = PaketSoalResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Info Paket')->schema([
                TextEntry::make('judul')->label('Judul Paket')->weight('bold'),
                TextEntry::make('mapel.jenjang.nama')->label('Jenjang')->badge()->color('info'),
                TextEntry::make('mapel.nama')->label('Mata Pelajaran'),
                TextEntry::make('pembuat.name')->label('Dibuat Oleh')->default('—'),
                TextEntry::make('created_at')->label('Dibuat Pada')->dateTime('d M Y, H:i'),
            ])->columns(3),

            Section::make('Daftar Soal')->schema([
                \Filament\Infolists\Components\RepeatableEntry::make('bankSoals')
                    ->label('')
                    ->schema([
                        TextEntry::make('mapel.nama')->label('Mapel'),
                        TextEntry::make('tipe_soal')
                            ->label('Tipe')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state === 'pilihan_ganda' ? 'PG' : 'Esai')
                            ->color(fn ($state) => $state === 'pilihan_ganda' ? 'primary' : 'success'),
                        TextEntry::make('pertanyaan')->label('Pertanyaan')->columnSpan(4),
                    ])
                    ->columns(6)
                    ->columnSpanFull(),
            ]),
        ]);
    }
}
