<?php

namespace App\Filament\Admin\Resources\Cashflow\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CashflowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Tipe Transaksi')
                    ->options(['income' => 'Pemasukan', 'expense' => 'Pengeluaran'])
                    ->required(),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'spp' => 'SPP',
                        'pendaftaran' => 'Pendaftaran',
                        'gaji_guru' => 'Gaji Guru',
                        'operasional' => 'Operasional',
                    ])
                    ->required(),
                TextInput::make('nominal')
                    ->label('Nominal')
                    ->required()
                    ->numeric(),
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required(),
                TextInput::make('reference_id')
                    ->label('ID Referensi'),
                Select::make('reference_type')
                    ->label('Tipe Referensi')
                    ->options([
                        \App\Models\Siswa::class => 'Siswa',
                        \App\Models\Penggajian::class => 'Penggajian (Gaji Guru)',
                        \App\Models\SesiKelas::class => 'Sesi Kelas',
                    ]),
                TextInput::make('source_snapshot')
                    ->label('Sumber / Detail')
                    ->helperText('Otomatis terisi jika memilih referensi di atas'),
                TextInput::make('sumber_id')
                    ->label('ID Sumber (Siswa/Guru)')
                    ->numeric()
                    ->helperText('ID Sumber (Siswa/Guru) untuk laporan'),
            ]);
    }

}
