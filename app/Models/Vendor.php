<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'status'];

    protected $searchableFields = ['*'];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }
}
