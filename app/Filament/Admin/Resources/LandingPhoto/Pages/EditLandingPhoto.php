<?php
namespace App\Filament\Admin\Resources\LandingPhoto\Pages;
use App\Filament\Admin\Resources\LandingPhoto\LandingPhotoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
class EditLandingPhoto extends EditRecord
{
    protected static string $resource = LandingPhotoResource::class;
    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()->requiresConfirmation()];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
