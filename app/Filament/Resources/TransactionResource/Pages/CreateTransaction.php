<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransactionResource;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
