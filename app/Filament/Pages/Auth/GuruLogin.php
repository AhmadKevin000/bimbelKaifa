<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class GuruLogin extends BaseLogin
{
    public function getHeading(): string
    {
        return 'Portal Guru';
    }
}
