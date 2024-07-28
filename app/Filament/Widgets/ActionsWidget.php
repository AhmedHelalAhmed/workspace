<?php

namespace App\Filament\Widgets;

use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class ActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.invoice';
    protected int|string|array $columnSpan = 2;

    public function generateInvoice(): void
    {
        Notification::make()
            ->title('In progress successfully')
            ->success()
            ->body('Generating invoice.')
            ->send();
    }
}
