<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiGuru extends Model
{
    protected $table = 'absensi_guru';

    protected $fillable = [
        'sesi_kelas_id',
        'guru_id',
        'kelas_id',
        'mapel_id',
        'check_in',
        'check_out',
        'status',
        'kelas_name_snapshot',
        'guru_name_snapshot',
        'mapel_name_snapshot',
    ];

    protected static function booted()
    {
        static::saving(function ($absensi) {
            if ($absensi->kelas_id && empty($absensi->kelas_name_snapshot)) {
                $absensi->kelas_name_snapshot = $absensi->kelasSnapshot?->nama_kelas;
            }
            if ($absensi->guru_id && empty($absensi->guru_name_snapshot)) {
                $absensi->guru_name_snapshot = $absensi->guru?->nama;
            }
            if ($absensi->mapel_id && empty($absensi->mapel_name_snapshot)) {
                $absensi->mapel_name_snapshot = $absensi->mapel?->nama;
            }

            // Fallback to SesiKelas snapshots if direct relation results are empty
            if (empty($absensi->kelas_name_snapshot) && $absensi->sesiKelas) {
                $absensi->kelas_name_snapshot = $absensi->sesiKelas->kelas_name_snapshot;
            }
            if (empty($absensi->guru_name_snapshot) && $absensi->sesiKelas) {
                $absensi->guru_name_snapshot = $absensi->sesiKelas->guru_name_snapshot;
            }
            if (empty($absensi->mapel_name_snapshot) && $absensi->sesiKelas) {
                $absensi->mapel_name_snapshot = $absensi->sesiKelas->mapel_name_snapshot;
            }
        });
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelasSnapshot()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function sesiKelas()
    {
        return $this->belongsTo(SesiKelas::class, 'sesi_kelas_id');
    }

    /**
     * Helper to get class info - uses snapshot if available, fallback to sesiKelas
     */
    public function getKelasAttribute()
    {
        if ($this->kelas_name_snapshot) {
            return (object) ['nama_kelas' => $this->kelas_name_snapshot];
        }
        if ($this->kelas_id) {
            return $this->kelasSnapshot;
        }
        if ($this->sesiKelas?->kelas_name_snapshot) {
            return (object) ['nama_kelas' => $this->sesiKelas->kelas_name_snapshot];
        }
        return $this->sesiKelas?->kelas;
    }

    public function getPengajaranAttribute()
    {
        return (object) [
            'guru' => (object) [
                'nama' => $this->guru_name_snapshot ?? $this->guru?->nama ?? $this->sesiKelas?->guru_name_snapshot ?? 'Unknown',
                'status' => $this->guru?->status ?? 'baru',
            ],
            'mapel' => (object) [
                'nama' => $this->mapel_name_snapshot ?? $this->mapel?->nama ?? $this->sesiKelas?->mapel_name_snapshot ?? 'Unknown',
                'program' => $this->mapel?->program ?? '-',
                'jenjang' => $this->mapel?->jenjang ?? '-',
            ],
            'kelas' => (object) ['nama_kelas' => $this->kelas_name_snapshot ?? $this->kelas?->nama_kelas ?? $this->sesiKelas?->kelas_name_snapshot ?? '-'],
        ];
    }

    public function penggajian()
    {
        return $this->hasOne(Penggajian::class, 'absensi_guru_id');
    }

    public function absensiSiswa()
    {
        return $this->hasMany(AbsensiSiswa::class, 'sesi_kelas_id', 'sesi_kelas_id');
    }

    /**
     * Get count of students present dynamically
     */
    public function getJumlahSiswaHadirAttribute()
    {
        return $this->absensiSiswa()->where('status', 'hadir')->count();
    }
}
