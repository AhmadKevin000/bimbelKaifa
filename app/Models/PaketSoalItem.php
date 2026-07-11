<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketSoalItem extends Model
{
    protected $table = 'paket_soal_items';

    protected $fillable = [
        'paket_soal_id',
        'bank_soal_id',
        'urutan',
    ];

    public function paketSoal()
    {
        return $this->belongsTo(PaketSoal::class, 'paket_soal_id');
    }

    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class, 'bank_soal_id');
    }
}
