<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketSoal extends Model
{
    protected $table = 'paket_soals';

    protected $fillable = [
        'judul',
        'mapel_id',
        'dibuat_oleh',
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function bankSoals()
    {
        return $this->belongsToMany(BankSoal::class, 'paket_soal_items', 'paket_soal_id', 'bank_soal_id')
            ->withPivot('urutan')
            ->orderBy('paket_soal_items.urutan');
    }

    public function items()
    {
        return $this->hasMany(PaketSoalItem::class, 'paket_soal_id')->orderBy('urutan');
    }
}
