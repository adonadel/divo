<?php

namespace App\Repositories;

use App\Models\EstablishmentMedia;

class EstablishmentMediaRepository extends Repository
{
    protected function getModelClass(): string
    {
        return EstablishmentMedia::class;
    }


}
