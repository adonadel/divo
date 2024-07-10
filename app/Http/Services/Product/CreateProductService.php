<?php

namespace App\Http\Services\Product;

use App\Http\Services\Media\CreateMediaService;
use App\Repositories\ProductRepository;

class CreateProductService
{
    public function create(array $data)
    {
        $productRepository = new ProductRepository();

        $mediasIds = data_get($data, 'medias');

        $product = $productRepository->create($data)->load('establishment');

        if ($mediasIds && $exploded = explode(",", trim($mediasIds))) {
            $product->medias()->sync($exploded);
        }

        return $product->fresh()->load('establishment', 'medias');
    }

    public function createWithMedias(array $data)
    {
        $productRepository = new ProductRepository();

        $product = $productRepository->create($data);

        if (data_get($data, 'medias')) {
            foreach (data_get($data, 'medias') as $media){
                $createMediaService = new CreateMediaService();

                $media = $createMediaService->create($media);
                $product->medias()->sync($media->id);
            }
        }

        return $product->fresh()->load('establishment', 'medias');
    }
}
