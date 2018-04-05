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

            return $this->join('providers_has_companies', function ($join) {
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
            return $this->join('providers_has_companies', function ($join) {
                return $join->on('providerId', '=', 'providers.id');
            })
                ->where('providers_has_companies.companyId', '=', $companyId)
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
            return $this->join('providers_has_companies', function ($join) {
                return $join->on('providers_has_companies.providerId', '=', 'providers.id');
            })
                ->join('companies', function ($join) {
                    return $join->on('companies.id', '=', 'providers_has_companies.companyId');
                })
                ->select(
                    'providers.id AS id',
                    'providers.name AS name',
                    'companies.id AS companyId',
                    'companies.name AS companyName'
                )->where('providers_has_companies.status', '=', 0)
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
            return $this->join('providers_has_companies', function ($join) {
                return $join->on('providers_has_companies.providerId', '=', 'providers.id');
            })
                ->where([
                    ['providers.id', '=', $id],
                    ['providers_has_companies.companyId', '=', $companyId]
                ])->first();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return mixed
     */
    public function findCompaniesByProvider($providerId)
    {
        try {
            return \DB::table('companies')
                ->select(
                    'companies.id',
                    'companies.name'
                )->join('providers_has_companies', function ($join) {
                    $join->on('providers_has_companies.companyId', '=', 'companies.id');
                })->where('providers_has_companies.providerId', '=', $providerId)
                ->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return array
     */
    public function listIdCompanies($providerId)
    {
        $list = [];
        $rows = $this->findCompaniesByProvider($providerId);
        foreach ($rows as $row) {
            $list[] = $row->id;
        }
        return $list;
    }

    /**
     * @param int $providerId
     * @return mixed
     */
    public function findDocumentsByProvider($providerId)
    {
        try {
            return \DB::table('providers_has_documents')->where('providerId', '=', $providerId)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return array
     */
    public function findDocuments($providerId)
    {
        $rows = $this->findDocumentsByProvider($providerId);
        $documents = [];
        foreach ($rows as $row) {
            $documents[] = $row->documentId;
        }
        return $documents;
    }

    /**
     * @param array $providers
     * @param array $documents
     */
    public function attachDocuments(array $providers = [], array $documents = [])
    {
        $data = [];
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $stmt = \DB::table('providers_has_documents');

        foreach ($providers as $key => $value) {
            $stmt->where('providerId', $value)->delete();
            array_walk($documents, function ($item) use (&$data, &$value, &$now) {
                $data[] = [
                    'providerId' => $value,
                    'documentId' => $item,
                    'createdAt' => $now
                ];
            });
        }

        if (count($data)) {
            $stmt->insert($data);
        }
    }

    /**
     * @param int $providerId
     * @param int $companyId
     * @param bool $isAdmin
     */
    public function attachCompanies($providerId, $companyId, $isAdmin = false)
    {
        $stmt = \DB::table('providers_has_companies');
        $stmt->where('providerId', $providerId)->delete();
        $stmt->insert([
            'providerId' => $providerId,
            'companyId' => $companyId,
            'status' => $isAdmin,
            'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);
    }

}