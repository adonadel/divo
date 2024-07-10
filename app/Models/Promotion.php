<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    protected $fillable = [
        'product_id',
        'description',
        'date_start',
        'date_finish',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
