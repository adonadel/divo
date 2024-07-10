<?php

namespace App\Repositories;

use App\Models\EstablishmentRate;

class EstablishmentRateRepository extends Repository
{
    protected $table = 'establishment_rates';

    protected function getModelClass()
    {
        return EstablishmentRate::class;
    }
}
