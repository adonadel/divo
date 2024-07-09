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
            ->with(['address', 'category', 'user'])
            ->when($search, function(Builder $query, $search){
                $query
                    ->whereRaw('unaccent(name) ilike unaccent(?)', ["%{$search}%"])
                    ->orWhereRaw('unaccent(description) ilike unaccent(?)', ["%{$search}%"]);
            });

        if ($noPaginate) {
            return $query->get();
        }

        return $query->paginate();
    }


}
