<?php

namespace App\Filament\Resources\SocialMediaPlatformResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SocialMediaPlatformResource;

class ListSocialMediaPlatforms extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SocialMediaPlatformResource::class;
}
