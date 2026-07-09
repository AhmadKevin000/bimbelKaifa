<?php

namespace App\Filament\Admin\Resources\Cashflow\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashflowTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            ->modifyQueryUsing(fn ($query) => $query->orderBy('created_at', 'desc'))
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->time()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'income' => 'success',
                        'expense' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                        default => $state,
                    }),
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match (strtolower($state)) {
                        'spp' => 'SPP',
                        'pendaftaran' => 'Pendaftaran',
                        'gaji_guru' => 'Gaji Guru',
                        'operasional' => 'Operasional',
                        default => ucfirst($state),
                    })
                    ->searchable(),
                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR', locale: 'id')
                    ->color(fn ($record) => $record->type === 'income' ? 'success' : 'danger')
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('source_snapshot')
                    ->label('Sumber / Detail')
                    ->wrap()
                    ->placeholder(function ($record) {
                        $ref = $record->reference;
                        if (!$ref) return '-';

                        if ($record->reference_type === \App\Models\Penggajian::class) {
                            $sesi = $ref->absensiGuru->sesiKelas ?? null;
                            if ($sesi) {
                                $guru = $sesi->guru_name_snapshot ?? $sesi->pengajaran->guru->nama ?? 'Unknown';
                                $kelas = $sesi->kelas_name_snapshot ?? $sesi->pengajaran->kelas->nama_kelas ?? 'Unknown';
                                $mapel = $sesi->mapel_name_snapshot ?? $sesi->pengajaran->mapel->nama ?? 'Unknown';
                                return "{$guru} ({$kelas} - {$mapel})";
                            }
                            return 'Unknown';
                        }

                        if ($record->reference_type === \App\Models\Siswa::class) {
                            $kelas = $ref->kelas->nama_kelas ?? 'Tanpa Kelas';
                            return "{$ref->nama} ({$kelas})";
                        }

                        return '-';
                    })
                    ->searchable(query: function ($query, string $search) {
                        $query->where('source_snapshot', 'like', "%{$search}%")
                              ->orWhereHasMorph('reference', [\App\Models\Siswa::class, \App\Models\Penggajian::class], function ($q, $type) use ($search) {
                                  if ($type === \App\Models\Siswa::class) {
                                      $q->where('nama', 'like', "%{$search}%");
                                  } elseif ($type === \App\Models\Penggajian::class) {
                                      $q->whereHas('guru', fn($tq) => $tq->where('nama', 'like', "%{$search}%"))
                                        ->orWhereHas('absensiGuru.sesiKelas.pengajaran.kelas', fn($kq) => $kq->where('nama_kelas', 'like', "%{$search}%"));
                                  }
                              });
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'pendaftaran' => 'Pendaftaran',
                        'spp' => 'SPP',
                        'gaji_guru' => 'Gaji Guru',
                        'operasional' => 'Operasional',
                    ]),
                \Filament\Tables\Filters\Filter::make('tanggal')
                    ->label('Filter Tanggal')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('dari')
                            ->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari'], fn($q) => $q->whereDate('tanggal', '>=', $data['dari']))
                            ->when($data['sampai'], fn($q) => $q->whereDate('tanggal', '<=', $data['sampai']));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['dari'] ?? null) {
                            $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['dari'])->format('d M Y');
                        }
                        if ($data['sampai'] ?? null) {
                            $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['sampai'])->format('d M Y');
                        }
                        return $indicators;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

}
