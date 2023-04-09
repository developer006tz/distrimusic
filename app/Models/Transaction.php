<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['order_id', 'amount', 'date'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }
}
