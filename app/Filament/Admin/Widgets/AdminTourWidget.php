<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class AdminTourWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.admin-tour-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function getViewData(): array
    {
        return [
            'tourCompleted' => auth()->user()->tour_completed ?? false,
        ];
    }
}
