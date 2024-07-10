<?php

namespace App\Http\Services\Product;


use App\Exceptions\ProductAlreadyHasAnActivePromotionException;
use App\Repositories\PromotionRepository;

class CreatePromotionService
{
    private $promotionRepository;

    public function __construct()
    {
        $this->promotionRepository = new PromotionRepository();
    }

    public function create(array $data, int $id)
    {
        $exists = $this->promotionRepository->newQuery()
            ->where('product_id', $id)
            ->where('date_finish', '>=', date('Y-m-d'))
            ->exists();

        if ($exists) {
            throw new ProductAlreadyHasAnActivePromotionException('Produto já possui uma promoção ativa!');
        }

        $this->removeAllOldPromotions($id);

        $data['product_id'] = $id;

        return $this->promotionRepository->create($data);
    }

    private function removeAllOldPromotions(int $id)
    {
        $this->promotionRepository->newQuery()
            ->where('product_id', $id)
            ->delete();

        return $this;
    }
}
