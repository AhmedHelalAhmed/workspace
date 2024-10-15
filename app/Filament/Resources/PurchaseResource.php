<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Models\Product;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                    Forms\Components\Select::make('supplier_id')
                        ->relationship('supplier', 'name')
                        ->searchable()
                        ->required()
                        ->createOptionForm(
                            [
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\RichEditor::make('notes'),
                            ]
                        ),
                    Repeater::make('products')
                        ->relationship('purchaseProducts')
                        ->label('Products')
                        ->schema(
                            [
                                Forms\Components\Select::make('product_id')
                                    ->label('Product')
                                    ->getSearchResultsUsing(
                                        function (string $search) {
                                            return Product::query()
                                                ->where('name', 'LIKE', "{$search}%")
                                                ->limit(5)
                                                ->pluck('name', 'id');
                                        }
                                    )
                                    ->getOptionLabelUsing(
                                        function ($value) {
                                            return Product::query()->find($value)->name;
                                        }
                                    )
                                    ->searchable()
                                    ->required()
                                    ->createOptionForm(
                                        [
                                            Forms\Components\TextInput::make('name')
                                                ->required(),
                                            Forms\Components\RichEditor::make('notes'),
                                        ]
                                    ),
                                Forms\Components\TextInput::make('price')
                                    ->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->required(),
                                Forms\Components\Textarea::make('notes')
                                    ->rows(10)
                                    ->cols(20)
                                    ->autosize(),
                            ]
                        )
                        ->live()
                        ->lazy()
                        ->afterStateUpdated(
                            function (Get $get, Set $set) {
                                self::updateTotals($get, $set);
                            }
                        )
                        ->addActionLabel('Add product')
                        ->defaultItems(1)
                        ->minItems(1)
                        ->columnSpanFull()
                        ->columns(),
                    Forms\Components\TextInput::make('total')
                        ->readOnly()
                        ->required()
                        ->numeric()
                        ->default(0),
                    Forms\Components\RichEditor::make('notes')
                        ->columnSpanFull(),
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                function (Builder $query): Builder {
                    return $query->withCount(['products']);
                }
            )
            ->columns(
                [
                    Tables\Columns\TextColumn::make('supplier.name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('products.name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('products_count'),
                    Tables\Columns\TextColumn::make('total')
                        ->numeric(),
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
                    Tables\Actions\ViewAction::make(),
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
            )->defaultSort('id');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'view' => Pages\ViewPurchase::route('/{record}'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }

    private static function updateTotals(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('products'))
            ->filter(fn ($item) => ! empty($item['price']) && ! empty($item['amount']));

        $total = $selectedProducts->reduce(
            function ($subtotal, $product) {
                return $subtotal + ($product['price'] * $product['amount']);
            },
            0
        );

        $set('total', number_format($total, 2, '.', ''));
    }
}
