<?php

namespace App\Http\Services\Establishment;

use App\Exceptions\EstablishmentAlreadyFavoritedException;
use App\Repositories\FavoriteRepository;

class FavoriteEstablishmentService
{
    public function favorite(int $id, int $userId)
    {
        $favoriteRepository = new FavoriteRepository();

        $exists = $favoriteRepository->newQuery()
            ->where('user_id', $userId)
            ->where('establishment_id', $id)
            ->exists();

        if ($exists) {
            throw new EstablishmentAlreadyFavoritedException('Estabelecimento já favoritado para esse usuário');
        }

        $favoriteRepository->create([
            'establishment_id' => $id,
            'user_id' => $userId
        ]);

        return true;
    }
}
