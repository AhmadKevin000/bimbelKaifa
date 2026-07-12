<?php

namespace App\Filament\Admin\Resources\Siswa\Pages;

use App\Filament\Admin\Resources\Siswa\SiswaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    /**
     * Setelah siswa baru berhasil disimpan, simpan juga enrollment mapel
     * ke tabel siswa_pengajaran (khusus jenjang SMA yang pilih kelas & mapel).
     */
    protected function afterCreate(): void
    {
        $pengajaranIds = $this->data['pengajaran_ids'] ?? [];

        if (!empty($pengajaranIds)) {
            $this->validateAndSyncEnrollment($pengajaranIds);
        }
    }

    private function validateAndSyncEnrollment(array $pengajaranIds): void
    {
        $siswa = $this->record;
        $toSync = [];

        foreach ($pengajaranIds as $pengajaranId) {
            $pengajaran = \App\Models\Pengajaran::find($pengajaranId);
            if (!$pengajaran) continue;

            // Cek kapasitas
            if ($pengajaran->is_penuh) {
                \Filament\Notifications\Notification::make()
                    ->title("Mapel '{$pengajaran->mapel?->nama}' sudah penuh (maks. {$pengajaran->max_siswa} siswa).")
                    ->warning()
                    ->send();
                continue;
            }

            $toSync[] = $pengajaranId;
        }

        if (!empty($toSync)) {
            $siswa->pengajaranEnrolled()->sync($toSync);
        }
    }
}
