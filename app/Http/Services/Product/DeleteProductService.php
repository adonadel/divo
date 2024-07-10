<?php

namespace App\Http\Services\Product;


use App\Repositories\ProductRepository;

class DeleteProductService
{
    public function delete(int $id)
    {
        $repository = new ProductRepository();

        $product = $repository->getById($id);

        return $repository->delete($product);
    }
}
