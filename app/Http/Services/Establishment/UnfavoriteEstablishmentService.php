<?php

namespace App\Http\Services\Establishment;

use App\Repositories\FavoriteRepository;

class UnfavoriteEstablishmentService
{
    public function unfavorite(int $id, int $userId)
    {
        $favoriteRepository = new FavoriteRepository();

        $favoriteRepository->newQuery()
            ->where('user_id', $userId)
            ->where('establishment_id', $id)
            ->delete();

        return true;
    }
}
