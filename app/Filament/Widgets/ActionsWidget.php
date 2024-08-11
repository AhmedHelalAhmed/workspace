<?php

namespace App\Filament\Widgets;

use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class ActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.invoice';

    protected int|string|array $columnSpan = 2;

    public function generateHadith(): void
    {
        $hadith = null;
        while (! $hadith) {
            $hadith = $this->getHadith();
        }

        $name = data_get($hadith, 'id');
        $number = data_get($hadith, 'contents.number');
        $contents = data_get($hadith, 'contents.arab');
        Notification::make()
            ->duration(null)
            ->title("($name) - ($number)")
            ->body($contents)
            ->send();
    }

    private function getHadith(): ?array
    {
        $books = $this->getBooks();
        $book = Arr::random($books);
        $name = $book['id'];
        $number = rand(1, $book['available']);

        return Http::get("https://api.hadith.gading.dev/books/$name/$number")
            ->json('data');
    }

    private function getBooks(): array
    {
        return once(
            function () {
                return Http::get('https://api.hadith.gading.dev/books')->json('data');
            }
        );
    }
}
