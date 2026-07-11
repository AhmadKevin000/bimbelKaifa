<?php

namespace App\Filament\Admin\Resources\BankSoal\Pages;

use App\Filament\Admin\Resources\BankSoal\BankSoalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBankSoal extends CreateRecord
{
    protected static string $resource = BankSoalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
