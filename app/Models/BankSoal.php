<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BankSoal extends Model
{
    protected $table = 'bank_soals';

    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'tipe_soal',
        'pertanyaan',
        'gambar_soal',
        'kunci_jawaban_esai',
    ];

    protected $casts = [
        'tipe_soal' => 'string',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function opsiJawaban()
    {
        return $this->hasMany(OpsiJawaban::class, 'bank_soal_id')->orderBy('label');
    }

    public function opsiBenar()
    {
        return $this->hasMany(OpsiJawaban::class, 'bank_soal_id')->where('is_benar', true);
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    /**
     * Scope: filter soal berdasarkan jenjang_id (via relasi mapel->jenjang_id).
     * WAJIB dipakai untuk randomize agar tidak tercampur antar jenjang.
     */
    public function scopeJenjang(Builder $query, int $jenjangId): Builder
    {
        return $query->whereHas('mapel', fn ($q) => $q->where('jenjang_id', $jenjangId));
    }
}
