<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Pastikan user yang mengakses panel admin memiliki role 'admin'.
     * Jika bukan admin, redirect ke halaman login panel admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = 'web'; // Admin panel uses default 'web' guard

        if (auth($guard)->check() && auth($guard)->user()->role !== 'admin') {
            auth($guard)->logout();

            \Filament\Notifications\Notification::make()
                ->title('Akses Ditolak')
                ->body('Halaman ini hanya untuk Admin.')
                ->danger()
                ->send();

            return redirect()->route('filament.admin.auth.login');
        }

        return $next($request);
    }
}
