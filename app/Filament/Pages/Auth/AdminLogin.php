<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class AdminLogin extends BaseLogin
{
    public function getHeading(): string
    {
        return 'Login Admin';
    }
}
