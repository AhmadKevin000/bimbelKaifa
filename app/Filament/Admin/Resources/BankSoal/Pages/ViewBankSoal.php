<?php

namespace App\Filament\Admin\Resources\BankSoal\Pages;

use App\Filament\Admin\Resources\BankSoal\BankSoalResource;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewBankSoal extends ViewRecord
{
    protected static string $resource = BankSoalResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Soal')->schema([
                TextEntry::make('kelas.nama_kelas')->label('Kelas')->badge()->color('warning'),
                TextEntry::make('mapel.jenjang.nama')->label('Jenjang')->badge()->color('info'),
                TextEntry::make('mapel.nama')->label('Mata Pelajaran'),
                TextEntry::make('tipe_soal')
                    ->label('Tipe Soal')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pilihan_ganda' => 'primary',
                        'esai'          => 'success',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pilihan_ganda' => 'Pilihan Ganda',
                        'esai'          => 'Esai',
                        default         => $state,
                    }),
                TextEntry::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->columnSpanFull(),
                ImageEntry::make('gambar_soal')
                    ->label('Gambar Soal')
                    ->disk('public')
                    ->visible(fn ($record) => (bool) $record->gambar_soal)
                    ->columnSpanFull(),
                TextEntry::make('kunci_jawaban_esai')
                    ->label('Kunci Jawaban / Rubrik')
                    ->visible(fn ($record) => $record->tipe_soal === 'esai')
                    ->columnSpanFull(),
            ])->columns(3),
        ]);
    }
}
