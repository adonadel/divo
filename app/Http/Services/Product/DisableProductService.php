<?php

namespace App\Http\Services\Product;


use App\Enums\ProductStatusEnum;
use App\Exceptions\ProductAlreadyEnabledOrDisabledException;
use App\Repositories\ProductRepository;

class DisableProductService
{
    public function disable(int $id)
    {
        $productRepository = new ProductRepository();

        $product = $productRepository->getById($id);

        if ($product->status === ProductStatusEnum::DISABLED) {
            throw new ProductAlreadyEnabledOrDisabledException('Produto já desativado');
        }

        /*$productRepository->update($product, [
            'status' => ProductStatusEnum::DISABLED
        ]);*/

        return true;
    }
}
