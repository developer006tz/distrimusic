<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;
}
