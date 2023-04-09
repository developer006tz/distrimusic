<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'social_media_platform_id',
    ];

    protected $searchableFields = ['*'];

    public function socialMediaPlatform()
    {
        return $this->belongsTo(SocialMediaPlatform::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
