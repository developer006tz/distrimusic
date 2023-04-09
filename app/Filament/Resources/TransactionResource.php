<?php

namespace App\Filament\Resources;

use App\Models\Transaction;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\TransactionResource\Pages;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'date';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('order_id')
                        ->rules(['exists:orders,id'])
                        ->required()
                        ->relationship('order', 'date')
                        ->searchable()
                        ->placeholder('Order')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('amount')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Amount')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    DatePicker::make('date')
                        ->rules(['date'])
                        ->required()
                        ->placeholder('Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('order.date')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('amount')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('date')
                    ->toggleable()
                    ->date(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('order_id')
                    ->relationship('order', 'date')
                    ->indicator('Order')
                    ->multiple()
                    ->label('Order'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionResource\RelationManagers\VendorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
