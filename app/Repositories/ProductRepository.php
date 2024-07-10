<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends Repository
{
    protected $table = 'products';

    protected function getModelClass()
    {
        return Product::class;
    }

    public function getProducts(array $filters)
    {
        $noPaginate = data_get($filters, 'no-paginate', false);
        $search = data_get($filters, 'search');

        $query = $this->newQuery();

        $query
            ->with('medias')
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
