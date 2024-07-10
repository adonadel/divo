<?php

namespace App\Repositories;

use App\Models\Promotion;

class PromotionRepository extends Repository
{
    protected $table = 'promotions';

    protected function getModelClass(): string
    {
        return Promotion::class;
    }
}
