<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $table = 'medias';

    protected $fillable = [
        'display_name',
        'filename',
        'filename_id',
        'size',
        'extension',
        'description',
        'width',
        'height',
    ];
}
