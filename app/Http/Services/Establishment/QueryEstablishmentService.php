<?php

namespace App\Http\Services\Establishment;

use App\Repositories\EstablishmentRepository;
use App\Repositories\ProductRepository;

class QueryEstablishmentService
{
    public function getEstablishments(array $filters)
    {
        return (new EstablishmentRepository())->getEstablishments($filters);
    }

    public function getEstablishmentById(int $id)
    {
        $establishment = (new EstablishmentRepository())->getById($id)->load('address', 'user', 'category', 'rates', 'medias');

        if ($establishment->favorite()->where('user_id', auth()->id())->exists()) {
            $establishment->is_favorited = true;
        }

        if (count($establishment->rates) > 0) {
            $rates = $establishment->rates->pluck('rate');

            return [
                ...$establishment->toArray(),
                'overall_rating' => $rates->sum() / $rates->count(),
            ];
        }

        return $establishment;
    }

    public function getMyFavoriteEstablishments(int $userId)
    {
        $establishmentRepository = new EstablishmentRepository();

        $establishments = $establishmentRepository->newQuery()
            ->with(['address', 'user', 'category', 'rates', 'medias'])
            ->whereHas('favorite', function ($query) use ($userId){
                $query->where('user_id', $userId);
            })
            ->get();

        foreach ($establishments as $establishment) {
            if (count($establishment->rates) > 0) {
                $rates = $establishment->rates->pluck('rate');

                $establishment->overall_rating = $rates->sum() / $rates->count();
            }
        }

        return $establishments;
    }

    public function getEstablishmentProducts(int $id)
    {
        $productRepository = new ProductRepository();

        $products = $productRepository->newQuery()
            ->with(['promotion'])
            ->where('establishment_id', $id)
            ->get()
            ->map(function ($product) {
                if ($product->promotion && $product->promotion->date_finish >= date('Y-m-d')) {
                    $valueWithPromotion = round($product->value * ($product->promotion->percent / 100), 2);

                    $product->value_with_promotion = $valueWithPromotion;
                }
                return $product;
            });

        return $products;
    }
}
