<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'street',
        'neighborhood',
        'city',
        'state',
        'number',
        'complement',
        'zip',
        'longitude',
        'latitude',
    ];
}
