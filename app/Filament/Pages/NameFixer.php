<?php

namespace App\Filament\Pages;

use App\Filament\Components\CopyableReadOnlyTextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\Support\Str;

class NameFixer extends Page implements HasForms
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.name-fixer';

    public string $inputName;

    public string $camelcase;

    public string $snakeCase;

    public string $pascalCase;

    public string $upperSnakeCase;

    public string $uppercase;

    public string $lowercase;

    public string $find;

    public string $replace;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('inputName'),
            TextInput::make('find'),
            TextInput::make('replace'),
            Grid::make()
                ->schema(
                    [
                        CopyableReadOnlyTextInput::make('camelcase')
                            ->label('Camel Case'),
                        CopyableReadOnlyTextInput::make('snakeCase')
                            ->label('Snake Case'),
                        CopyableReadOnlyTextInput::make('pascalCase')
                            ->label('Pascal Case'),
                        CopyableReadOnlyTextInput::make('upperSnakeCase')
                            ->label('Upper Snake Case'),
                        CopyableReadOnlyTextInput::make('uppercase')
                            ->label('Uppercase'),
                        CopyableReadOnlyTextInput::make('lowercase')
                            ->label('Lowercase'),
                    ]
                ),

        ];
    }

    public function submit(): void
    {
        $name = str_replace($this->find ?? '', $this->replace ?? '', $this->inputName);
        $this->lowercase = Str::lower($name);
        $this->uppercase = Str::upper($name);
        $this->camelcase = Str::camel($name);
        $this->snakeCase = Str::snake($name);
        $this->pascalCase = $this->toPascalCase($this->lowercase);
        $this->upperSnakeCase = $this->toUpperSnakeCase($this->lowercase);
    }

    private function toPascalCase(string $string): string
    {
        return preg_replace_callback(
            '/(?:^|\W)(\w)/',
            function ($matches) {
                return strtoupper($matches[1]);
            },
            $string
        );
    }

    private function toUpperSnakeCase(string $string): string
    {
        // Replace non-alphanumeric characters (including spaces) with underscores
        $snakeCaseString = preg_replace('/[^a-z0-9]+/', '_', $string);
        // Trim any leading or trailing underscores
        $snakeCaseString = trim($snakeCaseString, '_');

        return strtoupper($snakeCaseString);
    }
}
