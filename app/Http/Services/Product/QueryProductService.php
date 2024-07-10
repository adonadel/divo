<?php

namespace App\Http\Services\Product;

use App\Repositories\ProductRepository;

class QueryProductService
{
    public function getProducts(array $filters)
    {
        $repository = new ProductRepository();

        return $repository->getProducts($filters);
    }

    public function getProductById(int $id)
    {
        return (new ProductRepository())->getById($id)->load([
            'establishment'
        ]);
    }

    public function getProductByIdExternal(int $id)
    {
        $product = (new ProductRepository())->getById($id);
        
        return [
            'name' => $product->name,
            'value' => $product->description,
        ];
    }
}
