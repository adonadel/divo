<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Establishment extends Model
{

    protected $fillable = [
        'name',
        'description',
        'cnpj',
        'opening_start',
        'opening_close',
        'address_id',
        'category_id',
        'user_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rates(): HasMany
    {
        return $this->hasMany(EstablishmentRate::class);
    }
}
