<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaPlatform extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'social_media_platforms';

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
