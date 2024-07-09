<?php

namespace App\Http\Services\Establishment;

use App\Repositories\AddressRepository;
use App\Repositories\EstablishmentRepository;

class CreateEstablishmentService
{

    public function create(array $data)
    {
        $repository = new EstablishmentRepository();

        if($addressData = data_get($data, 'address')) {
            $address = $this->handleAddress($addressData);
            $data['address_id'] = $address->id;
            unset($data['address']);
        }

        $establishment = $repository->create($data);

        return $establishment;
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
