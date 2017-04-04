<?php

namespace App\Repositories\Panel;

use App\Models\Provider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProviderRepository extends Provider
{

    protected $totalPerPage = 20;

    /**
     * @param int $companyId
     * @param string $field
     * @param string $keyword
     * @return mixed
     */
    public function findLike($companyId, $field, $keyword)
    {
        try {
            return Provider::join('companies_has_providers', function ($join) {
                return $join->on('providerId', '=', 'id');
            })->where([
                ['companyId', '=', $companyId],
                [$field, 'like', "%{$keyword}%"]
            ])->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $companyId
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($companyId, $field = 'id', $type = 'desc')
    {
        try {
            return Provider::join('companies_has_providers', function ($join) {
                return $join->on('providerId', '=', 'providers.id');
            })
                ->where('companies_has_providers.companyId', '=', $companyId)
                ->orderBy($field, $type)
                ->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param string $cnpj
     * @return mixed
     */
    public function findByCnpj($cnpj)
    {
        try {
            return Provider::where('cnpj', '=', $cnpj)->first();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }

    }

    /**
     * @param int $id
     * @param string $field
     * @return mixed
     */
    public function getName($id, $field = 'name')
    {
        try {
            return Provider::where('id', '=', $id)->pluck($field)->first();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        try {
            return (object)Provider::find($id)->original;
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @return mixed
     */
    public function findByPendency()
    {
        try {
            return Provider::join('companies_has_providers', function ($join) {
                return $join->on('providerId', '=', 'providers.id');
            })
                ->where('companies_has_providers.status', '=', 0)
                ->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $id
     * @param int $companyId
     * @return mixed
     */
    public function findByCompany($id, $companyId){
        try {
            return Provider::join('companies_has_providers', function ($join) {
                return $join->on('companies_has_providers.providerId', '=', 'providers.id');
            })
                ->where([
                    ['providers.id', '=', $id],
                    ['companies_has_providers.companyId', '=', $companyId]
                ])->first();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}