<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;

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
                        function ($livewire, $state) {
                            $livewire->dispatch('copy-to-clipboard', text: $state);
                        }
                    )
            )
            ->extraAttributes(
                [
                    'x-data' => '{
            copyToClipboard(text) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(() => {
                        $tooltip("Copied to clipboard", { timeout: 1500 });
                    }).catch(() => {
                        $tooltip("Failed to copy", { timeout: 1500 });
                    });
                } else {
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.position = "fixed";
                    textArea.style.opacity = "0";
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand("copy");
                        $tooltip("Copied to clipboard", { timeout: 1500 });
                    } catch (err) {
                        $tooltip("Failed to copy", { timeout: 1500 });
                    }
                    document.body.removeChild(textArea);
                }
            }
        }',
                    'x-on:copy-to-clipboard.window' => 'copyToClipboard($event.detail.text)',
                ]
            );
    }
}
