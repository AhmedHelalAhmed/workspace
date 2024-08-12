<?php

namespace Tests\Feature;

use App\Filament\Widgets\ActionsWidget;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class ActionsWidgetTest extends TestCase
{
    public function testClickNewHadith(): void
    {
        $books = self::getJSONFixture('books.json');
        $newHadith = self::getJSONFixture('show_hadith.json');

        Http::fake(
            [
                'https://api.hadith.gading.dev/books' => Http::response($books),
                'https://api.hadith.gading.dev/books/*/*' => Http::response($newHadith),
            ]
        );

        $hadith = data_get($newHadith, 'data.contents.arab');
        $this->assertNotNull($hadith);
        Livewire::test(ActionsWidget::class)
            ->call('generateHadith')
            ->assertNotified(
                Notification::make()
                    ->duration(null)
                    ->title('(bukhari) - (1)')
                    ->body($hadith)
            );
    }
}
