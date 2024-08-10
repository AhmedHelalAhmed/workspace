<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;

class NameSuggestion extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.name-suggestion';

    public string $name;

    public string $suggestedName;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
            TextInput::make('suggestedName')
                ->label('Suggested Name')
                ->readOnly(),
        ];
    }

    public function submit(): void
    {
        $response = Http::withToken(config('ai.site.aimlapi.token'))->acceptJson()
            ->post(
                config('ai.site.aimlapi.link'),
                [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'As a professional developer simplify the name and keep it readable: '.$this->name.' answer with one word',
                        ],
                    ],
                    'max_tokens' => 512,
                    'stream' => false,
                ]
            );
        if ($response->json('error.message')) {
            Notification::make()->title($response->json('error.message'))->danger()->send();
        } else {
            Notification::make()->title('Success')->success()->send();
            $this->suggestedName = $response->json('choices.0.message.content');
        }
    }
}
