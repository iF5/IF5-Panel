<?php

namespace App\Repositories\Panel;

use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeRepository extends Employee
{

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
            return $this->where([
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
            return $this->where([
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
            return $this->join('providers', function ($join) {
                return $join->on('providers.id', '=', 'employees.providerId');
            })->select(
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
     * @param int $employeeId
     * @return mixed
     */
    public function findCompaniesByEmployee($employeeId)
    {
        try {
            return \DB::table('employees_has_companies')->where('employeeId', '=', $employeeId)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $employeeId
     * @return array
     */
    public function listIdCompanies($employeeId)
    {
        $rows = $this->findCompaniesByEmployee($employeeId);
        $list = [];
        foreach ($rows as $row) {
            $list[] = $row->companyId;
        }
        return $list;
    }

    /**
     * @param int $employeeId
     * @return mixed
     */
    public function findDocumentsByEmployee($employeeId)
    {
        try {
            return \DB::table('employees_has_documents')->where('employeeId', '=', $employeeId)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $employeeId
     * @return array
     */
    public function listIdDocuments($employeeId)
    {
        $rows = $this->findDocumentsByEmployee($employeeId);
        $list = [];
        foreach ($rows as $row) {
            $list[] = $row->documentId;
        }
        return $list;
    }

    /**
     * @param array $employees
     * @param array $documents
     */
    public function attachDocuments(array $employees = [], array $documents = [])
    {
        $data = [];
        $now = (new \DateTime())->format('Y-m-d H:i:s');

        foreach ($employees as $key => $value) {
            $this->detachDocuments($value);
            array_walk($documents, function ($item) use (&$data, &$value, &$now) {
                $data[] = [
                    'employeeId' => $value,
                    'documentId' => $item,
                    'createdAt' => $now
                ];
            });
        }

        if (count($data)) {
            \DB::table('employees_has_documents')->insert($data);
        }
    }

    /**
     * @param int $employeeId
     */
    public function detachDocuments($employeeId)
    {
        \DB::table('employees_has_documents')->where('employeeId', $employeeId)->delete();
    }

    /**
     * @param array $employees
     * @param array $companies
     */
    public function attachCompanies(array $employees = [], array $companies = [])
    {
        $data = [];
        $now = (new \DateTime())->format('Y-m-d H:i:s');

        foreach ($employees as $key => $value) {
            $this->detachCompanies($value);
            array_walk($companies, function ($item) use (&$data, &$value, &$now) {
                $data[] = [
                    'employeeId' => $value,
                    'companyId' => $item,
                    'createdAt' => $now
                ];
            });
        }

        if (count($data)) {
            \DB::table('employees_has_companies')->insert($data);
        }
    }

    /**
     * @param int $employeeId
     */
    public function detachCompanies($employeeId)
    {
        \DB::table('employees_has_companies')->where('employeeId', $employeeId)->delete();
    }

    /**
     * @param array $data
     * @return array
     */
    public function register(array $data = [])
    {
        $indexes = [];
        foreach ($data as $row) {
            if (!isset($row['id']) || (int)$row['id'] <= 0) {
                unset($row['id']);
                $employee = $this->firstOrCreate($row);
                $indexes[] = $employee->id;
            } else {
                $this->findOrFail($row['id'])->update($data);
                $indexes[] = $row['id'];
            }
        }

        return $indexes;
    }

}