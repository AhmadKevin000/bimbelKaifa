<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    protected $table = 'pengajaran';

    protected $fillable = [
        'kelas_id',
        'guru_id',
        'mapel_id',
        'max_siswa',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_pengajaran', 'pengajaran_id', 'siswa_id')
            ->withTimestamps();
    }

    /**
     * Cek apakah masih ada slot tersedia untuk siswa baru.
     * null = tidak ada batas (non-SMA atau memang tidak dibatasi).
     */
    public function getSlotTersisaAttribute(): ?int
    {
        if (is_null($this->max_siswa)) {
            return null; // tidak terbatas
        }
        return max(0, $this->max_siswa - $this->siswa()->count());
    }

    public function getIsPenuhAttribute(): bool
    {
        if (is_null($this->max_siswa)) {
            return false;
        }
        return $this->siswa()->count() >= $this->max_siswa;
    }
}
