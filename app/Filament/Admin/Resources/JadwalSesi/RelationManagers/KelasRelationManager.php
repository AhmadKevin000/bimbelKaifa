<?php

namespace App\Filament\Admin\Resources\JadwalSesi\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Forms\Components;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Kelas;
use App\Models\JadwalSesi;
use App\Models\SesiKelas;
use Filament\Notifications\Notification;

class KelasRelationManager extends RelationManager
{
    protected static string $relationship = 'pengajaran';

    protected static ?string $title = 'Jadwal Pengajaran';
    
    protected static ?string $recordTitleAttribute = 'id';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Sesi')
                    ->required(),
                Forms\Components\Select::make('semester')
                    ->options([
                        'Semester 1' => 'Semester 1',
                        'Semester 2' => 'Semester 2',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas.nama_kelas')->label('Kelas')->sortable(),
                Tables\Columns\TextColumn::make('guru.nama')->label('Guru')->sortable(),
                Tables\Columns\TextColumn::make('mapel.nama')->label('Mata Pelajaran')->sortable(),
                Tables\Columns\TextColumn::make('kelas.jumlah_siswa')->label('Jumlah Siswa')->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester')
                    ->label('Semester')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DetachBulkAction::make(),
                ]),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('pindah_sesi')
                    ->label('Pindah Sesi')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->color('warning')
                    ->button()
                    ->form(function ($record) {
                        $currentSesiId = $this->getOwnerRecord()->id;
                        return [
                            Forms\Components\Select::make('jadwal_sesi_id')
                                ->label('Pindah ke Sesi')
                                ->options(
                                    JadwalSesi::where('id', '!=', $currentSesiId)
                                        ->get()
                                        ->mapWithKeys(fn ($sesi) => [
                                            $sesi->id => "{$sesi->nama} ({$sesi->jam_mulai} - {$sesi->jam_selesai})"
                                        ])
                                )
                                ->required()
                                ->searchable(),
                        ];
                    })
                    ->action(function ($record, array $data) {
                        $pengajaranId = $record->id;
                        $mapelId = $record->mapel_id;
                        $targetSesiId = $data['jadwal_sesi_id'];

                        // Get the pivot record (sesi_kelas)
                        $pivotRecord = SesiKelas::where('pengajaran_id', $pengajaranId)
                            ->where('jadwal_sesi_id', $this->getOwnerRecord()->id)
                            ->first();

                        if (!$pivotRecord) {
                            Notification::make()
                                ->title('Data tidak ditemukan')
                                ->danger()
                                ->send();
                            return;
                        }

                        $semester = $pivotRecord->semester;

                        // validasi mapel exist sebelum dipindah
                        $conflict = SesiKelas::whereHas('pengajaran', function ($q) use ($mapelId) {
                                $q->where('mapel_id', $mapelId);
                            })
                            ->where('jadwal_sesi_id', $targetSesiId)
                            ->where('semester', $semester)
                            ->exists();

                        if ($conflict) {
                            $mapelName = $record->mapel->nama ?? 'Unknown';
                            $targetSesi = JadwalSesi::find($targetSesiId);
                            Notification::make()
                                ->title("Gagal Pindah Sesi")
                                ->body("Mapel {$mapelName} sudah ada di sesi {$targetSesi->nama} ({$targetSesi->jam_mulai}) pada {$semester}.")
                                ->danger()
                                ->send();
                            return;
                        }

                        // pindah sesi
                        $pivotRecord->update(['jadwal_sesi_id' => $targetSesiId]);

                        $targetSesi = JadwalSesi::find($targetSesiId);
                        Notification::make()
                            ->title("Berhasil Dipindahkan")
                            ->body("Mapel berhasil dipindahkan ke sesi {$targetSesi->nama} ({$targetSesi->jam_mulai} - {$targetSesi->jam_selesai}).")
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\DetachAction::make()
                    ->label('Delete')
                    ->modalHeading('Hapus Jadwal (Lepas Mapel)')
                    ->button()
                    ->color('danger'),
            ]);
    }

}
