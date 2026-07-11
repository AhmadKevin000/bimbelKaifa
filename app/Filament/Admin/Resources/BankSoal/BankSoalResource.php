<?php

namespace App\Filament\Admin\Resources\BankSoal;

use App\Filament\Admin\Resources\BankSoal\Pages\CreateBankSoal;
use App\Filament\Admin\Resources\BankSoal\Pages\EditBankSoal;
use App\Filament\Admin\Resources\BankSoal\Pages\ListBankSoal;
use App\Filament\Admin\Resources\BankSoal\Pages\ViewBankSoal;
use App\Filament\Admin\Resources\BankSoal\Pages\ImportBankSoal;
use App\Models\BankSoal as BankSoalModel;
use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\Mapel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\Action;

class BankSoalResource extends Resource
{
    protected static ?string $model = BankSoalModel::class;

    protected static ?string $modelLabel = 'Soal';
    protected static ?string $pluralModelLabel = 'Bank Soal';

    public static function getNavigationItems(): array
    {
        return [
            \Filament\Navigation\NavigationItem::make('Daftar Soal')
                ->group('Akademik')
                ->icon('heroicon-o-document-text')
                ->url(static::getUrl('index'))
                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.bank-soals.index') || request()->routeIs('filament.admin.resources.bank-soals.create') || request()->routeIs('filament.admin.resources.bank-soals.edit') || request()->routeIs('filament.admin.resources.bank-soals.view'))
                ->sort(4),
            \Filament\Navigation\NavigationItem::make('Import Soal')
                ->group('Akademik')
                ->icon('heroicon-o-arrow-up-tray')
                ->url(static::getUrl('import'))
                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.bank-soals.import'))
                ->sort(5),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Soal')->schema([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn ($set) => $set('mapel_id', null)),

                Select::make('jenjang_id')
                    ->label('Jenjang')
                    ->options(Jenjang::pluck('nama', 'id'))
                    ->live()
                    ->required()
                    ->afterStateUpdated(fn ($set) => $set('mapel_id', null))
                    ->dehydrated(false),

                Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->options(fn ($get) => Mapel::when(
                        $get('jenjang_id'),
                        fn ($q, $jenjangId) => $q->where('jenjang_id', $jenjangId)
                    )->pluck('nama', 'id'))
                    ->required()
                    ->searchable(),

                Select::make('tipe_soal')
                    ->label('Tipe Soal')
                    ->options(['pilihan_ganda' => 'Pilihan Ganda', 'esai' => 'Esai'])
                    ->default('pilihan_ganda')
                    ->live()
                    ->required(),

                Textarea::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                FileUpload::make('gambar_soal')
                    ->label('Gambar Soal (opsional)')
                    ->image()
                    ->directory('bank_soal')
                    ->disk('public')
                    ->nullable()
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Opsi Jawaban (Pilihan Ganda)')
                ->visible(fn ($get) => $get('tipe_soal') === 'pilihan_ganda')
                ->schema([
                    Repeater::make('opsiJawaban')
                        ->label('Opsi Jawaban')
                        ->relationship('opsiJawaban')
                        ->schema([
                            Select::make('label')
                                ->options(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'])
                                ->required(),
                            Textarea::make('teks')
                                ->label('Teks Opsi')
                                ->rows(2)
                                ->nullable(),
                            FileUpload::make('gambar')
                                ->label('Gambar Opsi')
                                ->image()
                                ->directory('bank_soal')
                                ->disk('public')
                                ->nullable(),
                            Toggle::make('is_benar')
                                ->label('Jawaban Benar')
                                ->default(false),
                        ])
                        ->columns(2)
                        ->defaultItems(4)
                        ->minItems(4)
                        ->maxItems(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Kunci Jawaban (Esai)')
                ->visible(fn ($get) => $get('tipe_soal') === 'esai')
                ->schema([
                    Textarea::make('kunci_jawaban_esai')
                        ->label('Kunci Jawaban / Rubrik Penilaian (opsional)')
                        ->helperText('Kosongkan jika soal ini dinilai manual oleh guru.')
                        ->rows(4)
                        ->nullable()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('mapel.jenjang.nama')
                    ->label('Jenjang')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('mapel.nama')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipe_soal')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pilihan_ganda' => 'primary',
                        'esai'          => 'success',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pilihan_ganda' => 'Pilihan Ganda',
                        'esai'          => 'Esai',
                        default         => $state,
                    }),
                TextColumn::make('pertanyaan')
                    ->label('Pertanyaan')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('opsiJawaban_count')
                    ->label('Opsi')
                    ->counts('opsiJawaban')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas'),
                SelectFilter::make('tipe_soal')
                    ->label('Tipe Soal')
                    ->options(['pilihan_ganda' => 'Pilihan Ganda', 'esai' => 'Esai']),
                SelectFilter::make('jenjang')
                    ->label('Jenjang')
                    ->relationship('mapel.jenjang', 'nama'),
                SelectFilter::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->relationship('mapel', 'nama'),
            ])
            ->headerActions([
                Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->url(fn () => ImportBankSoal::getUrl()),
                Action::make('template')
                    ->label('Download Template')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(route('bank-soal.template'))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('id', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBankSoal::route('/'),
            'create' => CreateBankSoal::route('/create'),
            'import' => ImportBankSoal::route('/import'),
            'view'   => ViewBankSoal::route('/{record}'),
            'edit'   => EditBankSoal::route('/{record}/edit'),
        ];
    }
}
