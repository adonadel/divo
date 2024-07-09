<?php

namespace App\Http\Services\User;


use App\Enums\UserTypeEnum;
use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;

class CreateUserService
{
    public function create(array $data)
    {
        $userRepository = new UserRepository();

        if($addressData = data_get($data, 'address')) {
            $address = $this->handleAddress($addressData);
            $data['address_id'] = $address->id;
            unset($data['address']);
        }

        $data['type'] = UserTypeEnum::USER;

        return $userRepository->create($data)->load('address');
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
