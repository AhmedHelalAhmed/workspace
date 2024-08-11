<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GistResource\Pages;
use App\Models\Gist;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GistResource extends Resource
{
    protected static ?string $model = Gist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    TextInput::make('description'),
                    TextInput::make('link'),
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                [
                    Tables\Columns\TextColumn::make('description')->searchable(),
                ]
            )
            ->filters(
                [
                    //
                ]
            )
            ->actions(
                [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),

                ]
            )
            ->bulkActions(
                [
                    Tables\Actions\BulkActionGroup::make(
                        [
                            Tables\Actions\DeleteBulkAction::make(),
                        ]
                    ),
                ]
            )
            ->recordUrl(
                fn (Gist $record): string => $record->link,
            )
            ->openRecordUrlInNewTab();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGists::route('/'),
        ];
    }
}
