<?php

namespace App\Http\Services\Product;

use App\Repositories\ProductRepository;

class UpdateProductService
{
    public function update(int $id, array $data)
    {
        $productRepository = new ProductRepository();

        $mediasIds = data_get($data, 'medias');

        $product = $productRepository->getById($id);

        if ($mediasIds && $exploded = explode(",", trim($mediasIds))) {
            $product->medias()->sync($exploded);
        }

        return $productRepository->update($product, $data);
    }
}
