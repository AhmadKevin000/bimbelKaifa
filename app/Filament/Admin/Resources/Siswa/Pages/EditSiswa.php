<?php

namespace App\Filament\Admin\Resources\Siswa\Pages;

use App\Filament\Admin\Resources\Siswa\SiswaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Setelah siswa diupdate, sync enrollment mapel ke siswa_pengajaran.
     * Hanya berlaku jika field pengajaran_ids ada di form (jenjang SMA & ada kelas).
     */
    protected function afterSave(): void
    {
        $pengajaranIds = $this->data['pengajaran_ids'] ?? null;

        // Jika field tidak ada di form (non-SMA), tidak lakukan apa-apa
        if ($pengajaranIds === null) {
            return;
        }

        $siswa = $this->record;

        // Jika array kosong, clear semua enrollment
        if (empty($pengajaranIds)) {
            $siswa->pengajaranEnrolled()->detach();
            return;
        }

        $toSync = [];

        foreach ($pengajaranIds as $pengajaranId) {
            $pengajaran = \App\Models\Pengajaran::find($pengajaranId);
            if (!$pengajaran) continue;

            // Skip capacity check untuk enrollment yang sudah ada (update)
            $alreadyEnrolled = $siswa->pengajaranEnrolled()
                ->where('pengajaran_id', $pengajaranId)
                ->exists();

            if (!$alreadyEnrolled && $pengajaran->is_penuh) {
                \Filament\Notifications\Notification::make()
                    ->title("Mapel '{$pengajaran->mapel?->nama}' sudah penuh (maks. {$pengajaran->max_siswa} siswa).")
                    ->warning()
                    ->send();
                continue;
            }

            $toSync[] = $pengajaranId;
        }

        $siswa->pengajaranEnrolled()->sync($toSync);
    }
}
