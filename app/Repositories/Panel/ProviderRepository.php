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
            
            return $this->join('companies_has_providers', function ($join) {
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
            return $this->join('companies_has_providers', function ($join) {
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
            return $this->where('cnpj', '=', $cnpj)->first();
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
            return $this->where('id', '=', $id)->pluck($field)->first();
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
            return (object)$this->find($id)->original;
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
            return $this->join('companies_has_providers', function ($join) {
                return $join->on('companies_has_providers.providerId', '=', 'providers.id');
            })
                ->join('companies', function ($join) {
                    return $join->on('companies.id', '=', 'companies_has_providers.companyId');
                })
                ->select(
                    'providers.id AS id',
                    'providers.name AS name',
                    'companies.id AS companyId',
                    'companies.name AS companyName'
                )->where('companies_has_providers.status', '=', 0)
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
    public function findByCompany($id, $companyId)
    {
        try {
            return $this->join('companies_has_providers', function ($join) {
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

    /**
     * @param int $id
     * @return mixed
     */
    public function findDocuments($id)
    {
        try {
            return json_decode($this->find($id)->documents, true);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return array
     */
    public function listCompaniesByProvider($providerId)
    {
        $list = [];
        $companies = \DB::table('companies_has_providers')->where([
            ['providerId', '=', $providerId]
        ])->get();

        foreach ($companies as $company) {
            $list[] = $company->companyId;
        }
        return $list;
    }

}