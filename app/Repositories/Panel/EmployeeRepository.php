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
        try {
            return (object)Employee::find($id)->original;
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
            return Employee::selectRaw('*, 0 AS companyId')
                ->where('status', '=', 0)
                ->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return mixed
     */
    public function findAllByCompany($providerId)
    {
        try {
            return \DB::table('companies')
                ->select(
                    'companies.id',
                    'companies.name',
                    'employees_has_companies.employeeId',
                    'employees_has_companies.companyId'
                )
                ->join('companies_has_providers', function ($join) {
                    return $join->on('companies_has_providers.companyId', '=', 'companies.id');
                })
                ->leftJoin('employees_has_companies', function ($leftJoin) {
                    return $leftJoin->on('employees_has_companies.companyId', '=', 'companies.id');
                })
                ->distinct()
                ->where('companies_has_providers.providerId', '=', $providerId)
                ->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}