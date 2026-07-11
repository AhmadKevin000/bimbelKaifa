<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsGuru
{
    /**
     * Pastikan user yang mengakses panel guru memiliki role 'guru'.
     * Jika bukan guru, redirect ke halaman login panel guru.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('guru')->check() && auth('guru')->user()->role !== 'guru') {
            auth('guru')->logout();

            \Filament\Notifications\Notification::make()
                ->title('Akses Ditolak')
                ->body('Halaman ini hanya untuk Guru.')
                ->danger()
                ->send();

            return redirect()->route('filament.guru.auth.login');
        }

        return $next($request);
    }
}
