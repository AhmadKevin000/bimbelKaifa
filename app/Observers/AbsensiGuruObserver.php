<?php

namespace App\Observers;

use App\Models\AbsensiGuru;
use App\Models\Penggajian;
use App\Services\SalaryService;

class AbsensiGuruObserver
{
    /**
     * Handle the AbsensiGuru "updated" event.
     */
    public function updated(AbsensiGuru $absensiGuru): void
    {
        // status berubah -> pencatatan
        if ($absensiGuru->isDirty('status') && $absensiGuru->status === 'selesai') {
            
            // cek duplikasi di penggajian
            if ($absensiGuru->penggajian()->exists()) {
                return;
            }

            // menghitung gaji dari logic gaji di services
            $hadirCount = $absensiGuru->jumlah_siswa_hadir;
            $salaryDetail = (new SalaryService())->calculateDetailed($absensiGuru, $hadirCount);

            Penggajian::create([
                'absensi_guru_id' => $absensiGuru->id,
                'guru_id' => $absensiGuru->guru_id,
                'tarif_gaji_id' => $salaryDetail['tarif_gaji_id'],
                'nominal' => $salaryDetail['total_fee'],
                'rate_snapshot' => $salaryDetail['rate_snapshot'],
                'status_pembayaran' => 'paid', // Flow otomatis -> langsung paid
                'tanggal_pembayaran' => now(),
            ]);
        }
    }
}
