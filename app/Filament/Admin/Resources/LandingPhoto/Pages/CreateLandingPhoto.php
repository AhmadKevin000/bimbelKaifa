<?php
namespace App\Filament\Admin\Resources\LandingPhoto\Pages;
use App\Filament\Admin\Resources\LandingPhoto\LandingPhotoResource;
use Filament\Resources\Pages\CreateRecord;
class CreateLandingPhoto extends CreateRecord
{
    protected static string $resource = LandingPhotoResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
