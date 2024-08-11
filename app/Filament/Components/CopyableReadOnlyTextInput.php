<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Livewire\Component;

class CopyableReadOnlyTextInput extends TextInput
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->readOnly()
            ->suffixAction(
                Action::make('copy')
                    ->icon('heroicon-s-clipboard')
                    ->action(
                        function (Component $livewire, $state) {
                            $livewire->js('window.navigator.clipboard.writeText("'.$state.'");');
                            Notification::make()->title('Copied to clipboard')->success()->send();
                        }
                    )
            );
    }
}
