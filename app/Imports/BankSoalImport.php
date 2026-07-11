<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BankSoalImport implements WithMultipleSheets
{
    protected array $uploadedImages;

    public function __construct(array $uploadedImages = [])
    {
        $this->uploadedImages = $uploadedImages;
    }

    public function sheets(): array
    {
        return [
            'Pilihan Ganda' => new PilihanGandaSheetImport($this->uploadedImages),
            'Esai'          => new EsaiSheetImport($this->uploadedImages),
        ];
    }

    public function getParsedResults(): array
    {
        return [
            'pilihan_ganda' => app(PilihanGandaSheetImport::class)->getRows(),
            'esai'          => app(EsaiSheetImport::class)->getRows(),
        ];
    }
}
