<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Aplikasi ini tidak punya route bernama "login" (login ada di panel
        // Filament), jadi tanpa ini setiap route ber-middleware auth melempar
        // RouteNotFoundException / 500 untuk guest. Arahkan ke login panel admin.
        $middleware->redirectGuestsTo(fn () => route('filament.admin.auth.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function ($schedule): void {
        $schedule->command('app:auto-checkout-sessions')->everyThirtyMinutes();
        $schedule->command('app:generate-daily-sessions')->dailyAt('00:01');
        // SPP payment reminder – H-7 sebelum jatuh tempo
        $schedule->command('app:send-spp-reminders')
            ->dailyAt('07:00')
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/spp-reminder.log'));
    })->create();
