<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Establishment $establishment
 * @property Media $medias
 */

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'value',
        'establishment_id',
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function medias(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'product_media');
    }
}
