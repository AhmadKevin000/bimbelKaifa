<?php
namespace App\Filament\Admin\Resources\LandingPhoto\Pages;
use App\Filament\Admin\Resources\LandingPhoto\LandingPhotoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
class ListLandingPhotos extends ListRecords
{
    protected static string $resource = LandingPhotoResource::class;
    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Tambah Slot Foto')];
    }
}
