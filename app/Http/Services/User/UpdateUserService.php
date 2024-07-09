<?php

namespace App\Http\Services\User;


use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;

class UpdateUserService
{
    public function update(array $data, int $id)
    {
        $userRepository = new UserRepository();

        if($addressData = data_get($data, 'address')) {
            $address = $this->handleAddress($addressData);
            $data['address_id'] = $address->id;
            unset($data['address']);
        }

        $user = $userRepository->getById($id);

        return $userRepository->update($user, $data);
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

    public function updateExternal(array $data, int $id)
    {
        $userRepository = new UserRepository();

        if($addressData = data_get($data, 'address')) {
            $address = $this->handleAddress($addressData);
            $data['address_id'] = $address->id;
            unset($data['address']);
        }

        $user = $userRepository->getById($id);

        $userRepository->update($user, $data);

        return $user->fresh()->load(['address']);
    }
}
