<?php

namespace App\Filament\Admin\Pages;

use App\Models\LandingSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

/**
 * Edits the copy of the public landing page.
 *
 * Deliberately limited to content: layout, typography and spacing stay in Blade
 * and CSS. Pricing is untouched — it keeps coming from `tarif_spp` — and images
 * keep coming from the existing "Pengaturan Situs" (landing_photos) resource.
 */
class LandingContent extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|UnitEnum|null $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Konten Halaman Depan';

    protected static ?string $title = 'Konten Halaman Depan';

    protected static ?int $navigationSort = 7;

    protected static ?string $slug = 'konten-halaman-depan';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(LandingSetting::current()?->only(array_keys(LandingSetting::DEFAULTS))
            ?? LandingSetting::DEFAULTS);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Hero')
                    ->description('Teks utama yang pertama dilihat pengunjung.')
                    ->columns(1)
                    ->schema([
                        TextInput::make('hero_title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(120)
                            ->helperText('Bungkus bagian yang ingin diberi sorotan kuning dengan tanda bintang, contoh: Belajar lebih *percaya diri*.'),

                        Textarea::make('hero_description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(400)
                            ->required(),
                    ]),

                Section::make('Tentang KAIFA')
                    ->columns(1)
                    ->schema([
                        Textarea::make('about_description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->maxLength(600),

                        Textarea::make('about_vision')
                            ->label('Visi')
                            ->rows(3)
                            ->maxLength(400),

                        Textarea::make('about_mission')
                            ->label('Misi')
                            ->rows(3)
                            ->maxLength(400),
                    ]),

                Section::make('Pertanyaan Umum (FAQ)')
                    ->description('Urutan di sini menentukan urutan tampil di halaman depan.')
                    ->columns(1)
                    ->schema([
                        Repeater::make('faqs')
                            ->hiddenLabel()
                            ->schema([
                                TextInput::make('question')
                                    ->label('Pertanyaan')
                                    ->required()
                                    ->maxLength(200),

                                Textarea::make('answer')
                                    ->label('Jawaban')
                                    ->required()
                                    ->rows(3)
                                    ->maxLength(600),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                            ->collapsible()
                            ->collapsed()
                            ->reorderable()
                            ->addActionLabel('Tambah pertanyaan')
                            ->defaultItems(0),
                    ]),

                Section::make('Perjalanan Belajar')
                    ->description('Tiga langkah pendampingan belajar yang ditampilkan di halaman depan.')
                    ->columns(1)
                    ->schema([
                        Repeater::make('process_steps')
                            ->hiddenLabel()
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul langkah')
                                    ->required()
                                    ->maxLength(120),

                                Textarea::make('description')
                                    ->label('Penjelasan')
                                    ->required()
                                    ->rows(3)
                                    ->maxLength(400),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->collapsible()
                            ->collapsed()
                            ->reorderable()
                            ->addActionLabel('Tambah langkah')
                            ->defaultItems(0),
                    ]),

                Section::make('Kontak & Jam Operasional')
                    ->description('Dipakai di navbar, footer, dan seluruh tautan WhatsApp.')
                    ->columns(1)
                    ->schema([
                        TextInput::make('contact_whatsapp')
                            ->label('Nomor WhatsApp')
                            ->required()
                            ->maxLength(20)
                            ->tel()
                            ->helperText('Boleh diawali 0 atau 62, contoh: 0819 3919 7272. Tanda +, spasi, dan tanda hubung otomatis dibersihkan.'),

                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(120),

                        Textarea::make('contact_address')
                            ->label('Alamat')
                            ->rows(2)
                            ->maxLength(255),

                        TextInput::make('contact_hours')
                            ->label('Jam operasional')
                            ->maxLength(120)
                            ->helperText('Contoh: Senin – Sabtu, 13.30 – 19.30 WIB'),

                        TextInput::make('contact_instagram')
                            ->label('Tautan Instagram')
                            ->url()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->getFormContentComponent(),
        ]);
    }

    protected function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Simpan perubahan')
                        ->submit('save')
                        ->keyBindings(['mod+s']),
                ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $data['contact_whatsapp'] = LandingSetting::normaliseWhatsapp($data['contact_whatsapp'] ?? null);

        LandingSetting::query()->updateOrCreate(['id' => 1], $data);

        Notification::make()
            ->success()
            ->title('Konten halaman depan disimpan')
            ->send();
    }
}
