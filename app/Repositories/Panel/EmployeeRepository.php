<?php

namespace App\Repositories\Panel;

use App\Models\Employee;

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
        return Employee::where([
            ['providerId', '=', $providerId],
            [$field, 'like', "%{$keyword}%"]
        ])->paginate($this->totalPerPage);
    }

    /**
     * @param int $providerId
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($providerId, $field = 'id', $type = 'desc')
    {
        return Employee::where([
            ['providerId', '=', $providerId]
        ])
            ->orderBy($field, $type)
            ->paginate($this->totalPerPage);
    }

}