<?php

namespace App\Filament\Admin\Resources\PaketSoal;

use App\Filament\Admin\Resources\PaketSoal\Pages\ListPaketSoal;
use App\Filament\Admin\Resources\PaketSoal\Pages\ViewPaketSoal;
use App\Filament\Admin\Resources\PaketSoal\Pages\GeneratePaketSoal;
use App\Models\PaketSoal as PaketSoalModel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Route;

class PaketSoalResource extends Resource
{
    protected static ?string $model = PaketSoalModel::class;

    protected static ?string $modelLabel = 'Paket Soal';
    protected static ?string $pluralModelLabel = 'Paket Soal';

    public static function getNavigationItems(): array
    {
        return [
            \Filament\Navigation\NavigationItem::make('Buat Paket Cetak')
                ->group('Akademik')
                ->icon('heroicon-o-sparkles')
                ->url(static::getUrl('generate'))
                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.paket-soals.generate'))
                ->sort(6),
            \Filament\Navigation\NavigationItem::make('Daftar Paket Soal')
                ->group('Akademik')
                ->icon('heroicon-o-document-duplicate')
                ->url(static::getUrl('index'))
                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.paket-soals.index') || request()->routeIs('filament.admin.resources.paket-soals.view'))
                ->sort(7),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Create hanya lewat Generate Acak
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('judul')
                    ->label('Judul Paket')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('mapel.jenjang.nama')
                    ->label('Jenjang')
                    ->badge()
                    ->color('info'),
                TextColumn::make('mapel.nama')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                TextColumn::make('items_count')
                    ->label('Jumlah Soal')
                    ->counts('items')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('pembuat.name')
                    ->label('Dibuat Oleh')
                    ->default('—'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->headerActions([
                Action::make('generate')
                    ->label('Generate Acak')
                    ->icon('heroicon-o-sparkles')
                    ->color('primary')
                    ->url(fn () => GeneratePaketSoal::getUrl()),
            ])
            ->actions([
                Action::make('cetak_soal')
                    ->label('Cetak Soal')
                    ->icon('heroicon-o-printer')
                    ->color('primary')
                    ->url(fn (PaketSoalModel $record) => route('bank-soal.paket.pdf', $record))
                    ->openUrlInNewTab(),
                Action::make('cetak_kunci')
                    ->label('Cetak Kunci')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->url(fn (PaketSoalModel $record) => route('bank-soal.paket.kunci', $record))
                    ->openUrlInNewTab(),
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'    => ListPaketSoal::route('/'),
            'generate' => GeneratePaketSoal::route('/generate'),
            'view'     => ViewPaketSoal::route('/{record}'),
        ];
    }
}
