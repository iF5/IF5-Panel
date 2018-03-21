<?php

namespace App\Repositories\Panel;

use App\Models\Crud\Create;
use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeRepository extends Employee
{

    use Create;

    protected $totalPerPage = 20;

    /**
     * @param int $providerId
     * @param string $field
     * @param string $keyword
     * @return mixed
     */
    public function findLike($providerId, $field, $keyword)
    {
        try {
            return Employee::where([
                ['providerId', '=', $providerId],
                [$field, 'like', "%{$keyword}%"]
            ])->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($providerId, $field = 'id', $type = 'desc')
    {
        try {
            return Employee::where([
                ['providerId', '=', $providerId]
            ])
                ->orderBy($field, $type)
                ->paginate($this->totalPerPage);
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
        //   try {
        return (object)$this->find($id)->original;
        //} catch (\Exception $e) {
        //  throw new ModelNotFoundException;
        //}
    }

    /**
     * @return mixed
     */
    public function findByPendency()
    {
        try {
            return Employee::join('providers', function ($join) {
                return $join->on('providers.id', '=', 'employees.providerId');
            })
                ->select(
                    'employees.id AS id',
                    'employees.name AS name',
                    'providers.id AS companyId',
                    'providers.name AS companyName'
                )
                ->where('employees.status', '=', 0)
                ->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return mixed
     */
    public function findCompanyByProvider($providerId)
    {
        try {
            return \DB::table('companies')
                ->select(
                    'companies.id',
                    'companies.name'
                )->join('companies_has_providers', function ($join) {
                    $join->on('companies_has_providers.companyId', '=', 'companies.id');
                })->where('companies_has_providers.providerId', '=', $providerId)
                ->get();

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findCompanyByEmployee($employeeId)
    {
        try {
            return \DB::table('employees_has_companies')->where('employeeId', '=', $employeeId)->get();
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
     * @param array $data
     * @return bool|string
     */
    public function saveInBatch($data)
    {
        return $this->insertBatchGetId($this->table, $data);
    }

    /**
     * @param array $employees
     * @param array $documents
     */
    public function attachDocumentsInBatch(array $employees = [], array $documents = [])
    {
        $data = [];
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        foreach ($employees as $key => $value) {
            array_walk($documents, function ($item) use (&$data, &$value, &$now) {
                $data[] = [
                    'employeeId' => $value,
                    'documentId' => $item,
                    'createdAt' => $now
                ];
            });
        }

        $this->insertBatch('employees_has_documents', $data);
        dd('LALALA');
    }

}