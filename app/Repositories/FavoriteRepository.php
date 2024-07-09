<?php

namespace App\Repositories;

use App\Models\Favorite;

class FavoriteRepository extends Repository
{

    protected function getModelClass(): string
    {
        return Favorite::class;
    }
}
