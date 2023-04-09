<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ServiceResource;

class ListServices extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ServiceResource::class;
}
