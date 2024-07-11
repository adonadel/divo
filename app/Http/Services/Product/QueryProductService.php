<?php

namespace App\Http\Services\Product;

use App\Repositories\FavoriteRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;

class QueryProductService
{
    public function getProducts(array $filters)
    {
        $repository = new ProductRepository();

        return $repository->getProducts($filters);
    }

    public function getProductById(int $id)
    {
        $product = (new ProductRepository())->getById($id)->load(['establishment', 'promotion']);

        if ($product->promotion && $product->promotion->date_finish >= date('Y-m-d')) {
            $valueWithPromotion = round($product->value * ($product->promotion->percent / 100), 2);

            return [
                ...$product->toArray(),
                'value_with_promotion' => $valueWithPromotion,
            ];
        }

        return $product;
    }

    public function getPromotions()
    {
        $promotionRepository = new PromotionRepository();

        $promotions = $promotionRepository->newQuery()
            ->with(['product', 'product.establishment'])
            ->where('date_finish', '>=', date('Y-m-d'))
            ->get()
            ->map(function ($promotion) {
                $valueWithPromotion = round($promotion->product->value * ($promotion->percent / 100), 2);

                $promotion->product->value_with_promotion = $valueWithPromotion;


                if (count($promotion->product->establishment->rates) > 0) {
                    $rates = $promotion->product->establishment->rates->pluck('rate');

                    $promotion->product->establishment->overall_rating = $rates->sum() / $rates->count();
                }

                $isFavorited = $this->isFavorited($promotion->product->establishment->id);

                if ($isFavorited) {
                    $promotion->product->establishment->is_favorited = true;
                }

                return $promotion;
            });

        return $promotions;
    }

    function isFavorited($establishmentId)
    {
        return (new FavoriteRepository())->newQuery()
            ->where('user_id', auth()->id())
            ->where('establishment_id', $establishmentId)
            ->exists();
    }
}
