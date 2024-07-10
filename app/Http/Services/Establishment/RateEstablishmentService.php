<?php

namespace App\Http\Services\Establishment;

use App\Repositories\EstablishmentRateRepository;

class RateEstablishmentService
{
    public function rate(int $id, array $data)
    {
        $rate = data_get($data, 'rate');

        $establishmentRateRepository = new EstablishmentRateRepository();

        $old = $establishmentRateRepository->newQuery()
            ->where('establishment_id', $id)
            ->where('user_id', $id)
            ->first();
        
        if ($old) {
            $old->delete();
        }

        $establishmentRateRepository->create([
            'establishment_id' => $id,
            'rate' => $rate,
            'user_id' => auth()->id(),
        ]);

        return true;
    }
}
