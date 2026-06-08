<?php

namespace App\Filament\Admin\Resources\LandingPhoto;

use App\Filament\Admin\Resources\LandingPhoto\Pages\CreateLandingPhoto;
use App\Filament\Admin\Resources\LandingPhoto\Pages\EditLandingPhoto;
use App\Filament\Admin\Resources\LandingPhoto\Pages\ListLandingPhotos;
use App\Models\LandingPhoto;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LandingPhotoResource extends Resource
{
    protected static ?string $model = LandingPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static string|\UnitEnum|null $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Foto Landing Page';
    protected static ?string $pluralLabel = 'Foto Landing Page';
    protected static ?string $modelLabel = 'Foto';
    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Slot Foto')->columns(2)->schema([

                TextInput::make('key')
                    ->label('Key (Slot Identifier)')
                    ->required()
                    ->maxLength(50)
                    ->unique(LandingPhoto::class, 'key', ignoreRecord: true)
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->dehydrated(fn (string $operation): bool => $operation === 'create')
                    ->helperText('Tidak bisa diubah setelah dibuat. Contoh: logo, hero, about, facility_1'),

                TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(255)
                    ->nullable()
                    ->placeholder('Library KAIFA'),
            ]),

            Section::make('Upload Foto')
                ->description('Format: JPG, PNG, WebP. Maksimal 5 MB. File disimpan di public/images/')
                ->schema([
                    FileUpload::make('image_path')
                        ->label('File Foto')
                        ->image()
                        ->required()
                        ->disk('public_images')
                        ->directory('')
                        ->imagePreviewHeight('220')
                        ->maxSize(5120)
                        ->acceptedFileTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
                        ->uploadingMessage('Mengupload foto...')
                        ->helperText('Foto lama akan dihapus otomatis jika diganti.')
                        ->deleteUploadedFileUsing(function (string $file) {
                            $path = public_path('images/' . $file);
                            if (file_exists($path)) {
                                unlink($path);
                            }
                        }),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Slot Key')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image_path')
                    ->label('Preview')
                    ->disk('public_images')
                    ->height(64)
                    ->width(96)
                    ->extraImgAttributes(['class' => 'object-cover rounded-lg']),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->placeholder('—'),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('key')
            ->recordActions([
                EditAction::make()->label('Ganti Foto'),
            ])
            ->toolbarActions([])
            ->emptyStateHeading('Belum ada data foto')
            ->emptyStateDescription('Jalankan: php artisan db:seed --class=LandingPhotoSeeder')
            ->emptyStateIcon('heroicon-o-photo');
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListLandingPhotos::route('/'),
            'create' => CreateLandingPhoto::route('/create'),
            'edit'   => EditLandingPhoto::route('/{record}/edit'),
        ];
    }
}
