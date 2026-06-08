<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Halaman Utama';

    public static function getNavigationLabel(): string
    {
        return 'Halaman Utama';
    }
}
