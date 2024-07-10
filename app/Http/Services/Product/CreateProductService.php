<?php

namespace App\Http\Services\Product;

use App\Repositories\ProductRepository;

class CreateProductService
{
    public function create(array $data, ?ProductTypeEnum $type)
    {
        $productRepository = new ProductRepository();

        if ($type !== null) {
            $data['type'] = $type;
        }

        if (data_get($data, 'type') === ProductTypeEnum::EXTERNAL) {
            $data['role_id'] = (new RoleRepository())->newQuery()->where('name', 'product')->first()->id;
        }

        return $productRepository->create($data)->load('establishment');
    }
}
