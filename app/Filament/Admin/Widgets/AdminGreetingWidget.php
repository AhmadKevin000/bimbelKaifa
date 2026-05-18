<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class AdminGreetingWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.admin-greeting-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getViewData(): array
    {
        $user = auth()->user();
        $hour = (int) now()->format('H');

        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        return [
            'greeting' => $greeting,
            'userName' => $user->name ?? 'Administrator',
            'tanggal' => now()->locale('id')->isoFormat('dddd, D MMMM Y'),
        ];
    }
}
