<?php

namespace App\Filament\Admin\Resources\Cashflow;

use App\Filament\Admin\Resources\Cashflow\Pages\CreateCashflow;
use App\Filament\Admin\Resources\Cashflow\Pages\EditCashflow;
use App\Filament\Admin\Resources\Cashflow\Pages\ListCashflow;
use App\Filament\Admin\Resources\Cashflow\Schemas\CashflowForm;
use App\Filament\Admin\Resources\Cashflow\Tables\CashflowTable;
use App\Models\Cashflow;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CashflowResource extends Resource
{
    protected static ?string $model = Cashflow::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Arus Kas';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $pluralLabel = 'Arus Kas';

    public static function form(Schema $schema): Schema
    {
        return CashflowForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CashflowTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Detail Transaksi')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('type')
                            ->label('Tipe Transaksi')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'income' => 'success',
                                'expense' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'income' => 'Pemasukan',
                                'expense' => 'Pengeluaran',
                                default => $state,
                            }),
                        \Filament\Infolists\Components\TextEntry::make('kategori')
                            ->label('Kategori')
                            ->badge()
                            ->color('info')
                            ->formatStateUsing(fn(string $state): string => match (strtolower($state)) {
                                'spp' => 'SPP',
                                'pendaftaran' => 'Pendaftaran',
                                'gaji_guru' => 'Gaji Guru',
                                'operasional' => 'Operasional',
                                default => ucfirst($state),
                            }),
                        \Filament\Infolists\Components\TextEntry::make('nominal')
                            ->label('Nominal')
                            ->money('IDR', locale: 'id')
                            ->weight('bold')
                            ->color(fn($record) => $record->type === 'income' ? 'success' : 'danger'),
                        \Filament\Infolists\Components\TextEntry::make('tanggal')
                            ->label('Tanggal Transaksi')
                            ->date(),
                        \Filament\Infolists\Components\TextEntry::make('created_at')
                            ->label('Waktu Dicatat')
                            ->dateTime('H:i:s, d M Y'),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Informasi Sumber & Referensi')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('source_snapshot')
                            ->label('Sumber / Detail')
                            ->placeholder('-'),
                        \Filament\Infolists\Components\TextEntry::make('reference_type')
                            ->label('Tipe Referensi')
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                \App\Models\Siswa::class => 'Siswa',
                                \App\Models\Penggajian::class => 'Penggajian (Gaji Guru)',
                                \App\Models\SesiKelas::class => 'Sesi Kelas',
                                default => $state ?? '-',
                            })
                            ->placeholder('-'),
                        \Filament\Infolists\Components\TextEntry::make('reference_id')
                            ->label('ID Referensi')
                            ->placeholder('-'),
                        \Filament\Infolists\Components\TextEntry::make('sumber_id')
                            ->label('ID Sumber (Siswa/Guru)')
                            ->placeholder('-'),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCashflow::route('/'),
            'create' => CreateCashflow::route('/create'),
            'edit' => EditCashflow::route('/{record}/edit'),
        ];
    }

}
