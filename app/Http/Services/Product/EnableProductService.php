<?php

namespace App\Http\Services\Product;


use App\Enums\ProductStatusEnum;
use App\Exceptions\ProductAlreadyEnabledOrDisabledException;
use App\Repositories\ProductRepository;

class EnableProductService
{
    public function enable(int $id)
    {
        $productRepository = new ProductRepository();

        $product = $productRepository->getById($id);

        if ($product->status === ProductStatusEnum::ENABLED) {
            throw new ProductAlreadyEnabledOrDisabledException('Produto já ativado');
        }

        $productRepository->update($product, [
            'status' => ProductStatusEnum::ENABLED
        ]);

        return true;
    }
}
