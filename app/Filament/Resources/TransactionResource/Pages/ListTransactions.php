<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\TransactionResource;

class ListTransactions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = TransactionResource::class;
}
