<?php

namespace App\Repositories\Panel;

use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyRepository extends Company
{

    protected $totalPerPage = 20;

    /**
     * @param string $field
     * @param string|null $keyword
     * @return mixed
     */
    public function findLike($field, $keyword = null)
    {
        try {
            return $this->where($field, 'like', "%{$keyword}%")->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($field = 'id', $type = 'desc')
    {
        try {
            return $this->orderBy($field, $type)->paginate($this->totalPerPage);
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
     * @param int $companyId
     * @return mixed
     */
    public function findDocumentsByCompany($companyId)
    {
        try {
            return \DB::table('companies_has_documents')->where('companyId', '=', $companyId)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $companyId
     * @return array
     */
    public function findDocuments($companyId)
    {
        $rows = $this->findDocumentsByCompany($companyId);
        $documents = [];
        foreach ($rows as $row) {
            $documents[] = $row->documentId;
        }
        return $documents;
    }

    /**
     * @param array $companies
     * @param array $documents
     */
    public function attachDocuments(array $companies = [], array $documents = [])
    {
        $data = [];
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $stmt = \DB::table('companies_has_documents');

        foreach ($companies as $key => $value) {
            $stmt->where('companyId', $value)->delete();
            array_walk($documents, function ($item) use (&$data, &$value, &$now) {
                $data[] = [
                    'companyId' => $value,
                    'documentId' => $item,
                    'createdAt' => $now
                ];
            });
        }

        if (count($data)) {
            $stmt->insert($data);
        }
    }

}