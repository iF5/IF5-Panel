<?php

namespace App\Repositories\Panel;

use App\Models\Provider;

class ProviderRepository extends Provider
{

    protected $totalPerPage = 20;

    /**
     * @param string $field
     * @param string $keyword
     * @param int $companyId
     * @return mixed
     */
    public function findLikeByCompany($field, $keyword, $companyId)
    {
        return Provider::join('companies_has_providers', function ($join) {
            return $join->on('providerId', '=', 'id');
        })->where([
            ['companyId', '=', $companyId],
            [$field, 'like', "%{$keyword}%"]
        ])->paginate($this->totalPerPage);
    }

    /**
     * @param int $companyId
     * @return mixed
     */
    public function findByCompany($companyId)
    {
        return Provider::join('companies_has_providers', function ($join) {
            return $join->on('providerId', '=', 'providers.id');
        })
            ->where('companies_has_providers.companyId', '=', $companyId)
            ->paginate($this->totalPerPage);
    }

    /**
     * @param string $cnpj
     * @return mixed
     */
    public function findByCnpj($cnpj)
    {
        return Provider::where('cnpj', '=', $cnpj)->first();
    }

    /**
     * @param int $id
     * @param string $field
     * @return mixed
     */
    public function getNameById($id, $field = 'name')
    {
        return Provider::where('id', '=', $id)
            ->pluck($field)
            ->first();
    }

}