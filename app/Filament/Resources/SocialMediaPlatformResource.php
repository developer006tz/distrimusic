<?php

namespace App\Filament\Resources;

use App\Models\SocialMediaPlatform;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\SocialMediaPlatformResource\Pages;

class SocialMediaPlatformResource extends Resource
{
    protected static ?string $model = SocialMediaPlatform::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('name')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('status')
                        ->rules(['in:1,0'])
                        ->required()
                        ->searchable()
                        ->options([
                            '1' => '1',
                            '0' => '0',
                        ])
                        ->placeholder('Status')
                        ->default('1')
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
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->searchable()
                    ->enum([
                        '1' => '1',
                        '0' => '0',
                    ]),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            SocialMediaPlatformResource\RelationManagers\ServicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialMediaPlatforms::route('/'),
            'create' => Pages\CreateSocialMediaPlatform::route('/create'),
            'view' => Pages\ViewSocialMediaPlatform::route('/{record}'),
            'edit' => Pages\EditSocialMediaPlatform::route('/{record}/edit'),
        ];
    }
}
