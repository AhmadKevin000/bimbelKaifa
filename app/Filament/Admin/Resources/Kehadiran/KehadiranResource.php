<?php

namespace App\Filament\Admin\Resources\Kehadiran;

use App\Filament\Admin\Resources\Kehadiran\Pages\ListKehadiran;
use App\Filament\Admin\Resources\Kehadiran\Pages\ViewKehadiran;
use App\Filament\Admin\Resources\Kehadiran\Tables\KehadiranTable;
use App\Models\SesiKelas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class KehadiranResource extends Resource
{
    protected static ?string $model = SesiKelas::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Akademik';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Kehadiran';
    protected static ?string $pluralLabel = 'Kehadiran';
    protected static ?string $modelLabel = 'Kehadiran';
    protected static ?string $slug = 'kehadiran';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'pengajaran.kelas.siswa',
                'pengajaran.guru',
                'pengajaran.mapel',
                'jadwalSesi',
                'absensiGuru',
                'absensiSiswa',
            ])
            ->orderBy('tanggal', 'desc')
            ->orderByRaw('(SELECT jam_mulai FROM jadwal_sesi WHERE jadwal_sesi.id = sesi_kelas.jadwal_sesi_id) ASC');
    }

    public static function getRecordTitle(?\Illuminate\Database\Eloquent\Model $record): ?string
    {
        if (!$record) return 'Kehadiran';
        $kelas = $record->pengajaran?->kelas?->nama_kelas ?? '-';
        $tanggal = $record->tanggal ? $record->tanggal->format('d M Y') : '-';
        return "Kehadiran: {$kelas} ({$tanggal})";
    }

    public static function table(Table $table): Table
    {
        return KehadiranTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKehadiran::route('/'),
            'view' => ViewKehadiran::route('/{record}'),
        ];
    }
}
