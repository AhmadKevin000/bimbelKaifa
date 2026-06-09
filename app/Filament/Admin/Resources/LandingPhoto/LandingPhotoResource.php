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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class LandingPhotoResource extends Resource
{
    protected static ?string $model = LandingPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string|\UnitEnum|null $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Pengaturan Situs';
    protected static ?string $pluralLabel = 'Pengaturan Situs';
    protected static ?string $modelLabel = 'Pengaturan Situs';
    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Slot Foto')->columns(1)->schema([

                Select::make('key')
                    ->label('Penempatan')
                    ->options([
                        'logo' => 'Logo',
                        'hero' => 'Hero',
                        'about' => 'About',
                        'facility_1' => 'Fasilitas 1',
                        'facility_2' => 'Fasilitas 2',
                        'facility_3' => 'Fasilitas 3',
                        'facility_4' => 'Fasilitas 4',
                    ])
                    ->required()
                    ->helperText('Pilih slot penempatan foto di halaman depan.'),

                TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(255)
                    ->nullable()
                    ->placeholder('Library KAIFA'),

                Checkbox::make('is_active')
                    ->label('Gunakan foto ini di halaman depan')
                    ->default(true)
                    ->helperText('Jika dicentang, foto ini akan aktif dan menonaktifkan foto lain pada slot yang sama.'),
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
                    ->label('Penempatan')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image_path')
                    ->label('Preview')
                    ->getStateUsing(fn($record) => asset('images/' . $record->image_path))
                    ->height(64)
                    ->width(96)
                    ->extraImgAttributes(['class' => 'object-cover rounded-lg']),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

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
            'index' => ListLandingPhotos::route('/'),
            'create' => CreateLandingPhoto::route('/create'),
            'edit' => EditLandingPhoto::route('/{record}/edit'),
        ];
    }
}
