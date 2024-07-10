<?php

namespace App\Repositories;

use App\Models\ProductMedia;

class ProductMediaRepository extends Repository
{
    protected $table = 'product_media';

    protected function getModelClass()
    {
        return ProductMedia::class;
    }
}
