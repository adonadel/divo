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
        return (new EstablishmentRepository())->getById($id)->load('address', 'user', 'category');
    }
}
