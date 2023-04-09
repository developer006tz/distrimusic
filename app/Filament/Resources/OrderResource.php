<?php

namespace App\Filament\Resources;

use App\Models\Order;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\OrderResource\Pages;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'date';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('user_id')
                        ->rules(['exists:users,id'])
                        ->required()
                        ->relationship('user', 'name')
                        ->searchable()
                        ->placeholder('User')
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

                    Select::make('status')
                        ->rules(['in:0,1'])
                        ->required()
                        ->searchable()
                        ->options([
                            '0' => '0',
                            '1' => '1',
                        ])
                        ->placeholder('Status')
                        ->default('0')
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
                Tables\Columns\TextColumn::make('user.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('date')
                    ->toggleable()
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->searchable()
                    ->enum([
                        '0' => '0',
                        '1' => '1',
                    ]),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->indicator('User')
                    ->multiple()
                    ->label('User'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderResource\RelationManagers\TransactionsRelationManager::class,
            OrderResource\RelationManagers\ServicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
