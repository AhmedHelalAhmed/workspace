<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariableResource\Pages;
use App\Models\Variable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VariableResource extends Resource
{
    protected static ?string $model = Variable::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Forms\Components\TextInput::make('key')->required(),
                    Forms\Components\TextInput::make('value'),
                    Forms\Components\MarkdownEditor::make('note')->columnSpan(2),
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                [
                    Tables\Columns\TextColumn::make('key'),
                    Tables\Columns\TextColumn::make('value'),
                    Tables\Columns\TextColumn::make('note')
                        ->limit(50)
                        ->wrap()
                        ->markdown(),
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
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVariables::route('/'),
        ];
    }
}
