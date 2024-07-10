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
        $product = (new ProductRepository())->getById($id)->load([
            'establishment',
            'promotion'
        ]);

        if ($product->promotion && $product->promotion->date_finish >= date('Y-m-d')) {
            $valueWithPromotion = round($product->value * ($product->promotion->percent / 100), 2);

            return [
                ...$product->toArray(),
                'value_with_promotion' => $valueWithPromotion,
            ];
        }

        return $product;
    }
}
