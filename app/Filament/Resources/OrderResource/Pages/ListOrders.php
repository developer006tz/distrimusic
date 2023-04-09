<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OrderResource;
use App\Filament\Traits\HasDescendingOrder;

class ListOrders extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = OrderResource::class;
}
