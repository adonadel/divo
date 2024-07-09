<?php

namespace App\Http\Services\Establishment;

use App\Repositories\AddressRepository;
use App\Repositories\EstablishmentRepository;

class UpdateEstablishmentService
{

    public function update(array &$data, int $id)
    {
        $repository = new EstablishmentRepository();

        $establishment = $repository->getById($id);

        if($addressData = data_get($data, 'address')) {
            $address = $this->handleAddress($addressData);
            $data['address_id'] = $address->id;
            unset($data['address']);
        }

        $repository->update($establishment, $data);

        return $establishment->fresh()->load('address', 'user', 'category');
    }

    private function handleAddress(array $addressData)
    {
        $addressRepository = new AddressRepository();

        if ($id = data_get($addressData, 'id')) {
            $address = $addressRepository->getById($id);
            $addressRepository->update($address, $addressData);
        }else {
            $address = $addressRepository->create($addressData);
        }

        return $address;
    }
}
