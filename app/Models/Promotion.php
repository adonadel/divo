<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    protected $table = 'promotions';
    
    protected $fillable = [
        'product_id',
        'description',
        'percent',
        'date_start',
        'date_finish',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
