<?php

namespace App\Http\Services\Product;

use App\Enums\ProductTypeEnum;
use App\Repositories\AddressRepository;
use App\Repositories\ProductRepository;

class UpdateProductService
{
    public function update(int $id)
    {
        $productRepository = new ProductRepository();

        $product = $productRepository->getById($id);

        return $productRepository->update($product);
    }

    public function updateExternal(array $data, int $id)
    {
        $productRepository = new ProductRepository();

        $product = $productRepository->getById($id);

        if ($product->type === ProductTypeEnum::INTERNAL) {
            return $product->fresh()->load(['establishment']);
        }
        return $product->fresh();
    }
}
