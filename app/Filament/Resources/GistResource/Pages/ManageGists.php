<?php

namespace App\Filament\Resources\GistResource\Pages;

use App\Filament\Actions\SyncGistsAction;
use App\Filament\Resources\GistResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGists extends ManageRecords
{
    protected static string $resource = GistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            SyncGistsAction::make('sync_gists'),
        ];
    }
}
