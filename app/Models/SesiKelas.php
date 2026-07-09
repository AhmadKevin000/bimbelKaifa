<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiKelas extends Model
{
    protected $table = 'sesi_kelas';

    protected $fillable = [
        'jadwal_sesi_id',
        'pengajaran_id',
        'guru_id',
        'tanggal',
        'semester',
        'kelas_name_snapshot',
        'guru_name_snapshot',
        'mapel_name_snapshot',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function (self $model) {
            if ($model->pengajaran) {
                // Only capture/override snapshot if the relationship is resolved
                if ($model->pengajaran->kelas) {
                    $model->kelas_name_snapshot = $model->pengajaran->kelas->nama_kelas;
                }
                if ($model->pengajaran->guru) {
                    $model->guru_name_snapshot = $model->pengajaran->guru->nama;
                    $model->guru_id = $model->pengajaran->guru_id;
                }
                if ($model->pengajaran->mapel) {
                    $model->mapel_name_snapshot = $model->pengajaran->mapel->nama;
                }
            }
        });
    }

    public function jadwalSesi()
    {
        return $this->belongsTo(JadwalSesi::class, 'jadwal_sesi_id');
    }

    public function pengajaran()
    {
        return $this->belongsTo(Pengajaran::class, 'pengajaran_id');
    }

    public function getKelasAttribute()
    {
        return $this->pengajaran?->kelas;
    }

    public function absensiGuru()
    {
        return $this->hasOne(AbsensiGuru::class, 'sesi_kelas_id');
    }

    public function absensiSiswa()
    {
        return $this->hasMany(AbsensiSiswa::class, 'sesi_kelas_id');
    }
}
