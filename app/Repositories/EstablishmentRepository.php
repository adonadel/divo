<?php

namespace App\Repositories;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Builder;

class EstablishmentRepository extends Repository
{
    protected function getModelClass(): string
    {
        return Establishment::class;
    }

    public function getEstablishments(array $filters)
    {
        $noPaginate = data_get($filters, 'no-paginate', false);
        $search = data_get($filters, 'search');

        $query = $this->newQuery();

        $query
            ->with(['address', 'category', 'user', 'rates'])
            ->when($search, function(Builder $query, $search){
                $query
                    ->whereRaw('unaccent(name) ilike unaccent(?)', ["%{$search}%"])
                    ->orWhereRaw('unaccent(description) ilike unaccent(?)', ["%{$search}%"]);
            });

        if ($noPaginate) {
            return $query->get()->map(function (Establishment $establishment) {
                if (count($establishment->rates) > 0) {
                    $rates = $establishment->rates->pluck('rate');

                    $establishment->overall_rating = $rates->sum() / $rates->count();
                }

                if ($establishment->favorite()->where('user_id', auth()->id())->exists()) {
                    $establishment->isFavorited = true;
                }
                return $establishment;
            });
        }

        return $query->paginate()->map(function (Establishment $establishment) {
            if (count($establishment->rates) > 0) {
                $rates = $establishment->rates->pluck('rate');

                $establishment->overall_rating = $rates->sum() / $rates->count();
            }
            
            if ($establishment->favorite()->where('user_id', auth()->id())->exists()) {
                $establishment->isFavorited = true;
            }
            return $establishment;
        });
    }


}
