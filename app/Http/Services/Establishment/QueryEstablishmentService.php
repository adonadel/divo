<?php

namespace App\Http\Services\Establishment;

use App\Repositories\EstablishmentRepository;

class QueryEstablishmentService
{
    public function getEstablishments(array $filters)
    {
        return (new EstablishmentRepository())->getEstablishments($filters);
    }

    public function getEstablishmentById(int $id)
    {
        $establishment = (new EstablishmentRepository())->getById($id)->load('address', 'user', 'category', 'rates');

        $rates = $establishment->rates->pluck('rate');

        return [
            ...$establishment->toArray(),
            'overall_rating' => $rates->sum() / $rates->count(),
        ];
    }
}
