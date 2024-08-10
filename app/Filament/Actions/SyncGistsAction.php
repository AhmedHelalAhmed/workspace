<?php

namespace App\Filament\Actions;

use App\Jobs\SyncGistsFromGithubJob;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class SyncGistsAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->label('Sync Gists')
            ->action(
                function () {
                    dispatch(new SyncGistsFromGithubJob);
                    Notification::make()->title('Synced')->success()->send();
                }
            );
    }
}
