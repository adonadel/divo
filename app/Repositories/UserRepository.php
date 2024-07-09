<?php

namespace App\Repositories;

use App\Models\User;
use App\Utils\CPFUtils;
use App\Utils\StringUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository
{
    protected function getModelClass(): string
    {
        return User::class;
    }

    public function getUsers(array $filters)
    {
        $noPaginate = data_get($filters, 'no-paginate', false);
        $search = data_get($filters, 'search');

        $query = $this->newQuery();

        $query
            ->with(['address', 'favorites'])
            ->when($search, function(Builder $query, $search){
               $check = StringUtils::checkIfStringStartWithNumber($search);
               return $query
                   ->whereRaw('unaccent(name) ilike unaccent(?)', ["%{$search}%"])
                   ->orWhere('email', 'ilike', "%{$search}%")
                   ->when($check, function ($query) use ($search){
                       $cleanedString = CPFUtils::removeNonAlphaNumericFromString($search);
                       $query->orWhere(
                            DB::raw("regexp_replace(\"cpf_cnpj\" , '[^0-9]*', '', 'g')"),
                            'ilike',
                            "{$cleanedString}%"
                        );
                });
            });

        if ($noPaginate) {
            return $query->get();
        }

        return $query->paginate();
    }

    public function getByEmail(string $email)
    {
        return $this->newQuery()
            ->where('email', $email)
            ->first();
    }
}
