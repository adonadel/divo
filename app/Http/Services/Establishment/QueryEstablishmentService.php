<?php

namespace App\Http\Services\Establishment;

use App\Repositories\EstablishmentRepository;

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
            ->whereHas('favorite', function ($query) use ($userId){
                $query->where('user_id', $userId);
            })
            ->get();

        return $establishments;
    }
}
