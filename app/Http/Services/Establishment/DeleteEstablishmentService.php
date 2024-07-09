<?php

namespace App\Http\Services\Establishment;

use App\Repositories\EstablishmentRepository;

class DeleteEstablishmentService
{

    public function delete(int $id)
    {
        $repository = new EstablishmentRepository();

        $establishment = $repository->getById($id);

        return $repository->delete($establishment);
    }
}
