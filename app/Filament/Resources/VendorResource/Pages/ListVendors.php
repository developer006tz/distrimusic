<?php

namespace App\Filament\Resources\VendorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\VendorResource;
use App\Filament\Traits\HasDescendingOrder;

class ListVendors extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = VendorResource::class;
}
