<?php

namespace App\Repositories;

use App\Models\Promotion;

class PromotionRepository extends Repository
{

    protected function getModelClass(): string
    {
        return Promotion::class;
    }
}
