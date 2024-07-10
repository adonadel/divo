<?php

namespace App\Http\Services\Product;


use App\Exceptions\ProductAlreadyHasAnActivePromotionException;
use App\Repositories\PromotionRepository;

class DeletePromotionService
{
    public function delete(int $id, int $promotionId)
    {
        $promotionRepository = new PromotionRepository();

        $exists = $promotionRepository->newQuery()
            ->where('product_id', $id)
            ->where('date_finish', '>=', date('Y-m-d'))
            ->exists();

        if (!$exists) {
            throw new ProductAlreadyHasAnActivePromotionException('Produto não possui uma promoção ativa!');
        }

        $promotionRepository->delete($promotionRepository->getById($promotionId));

        return true;
    }
}
