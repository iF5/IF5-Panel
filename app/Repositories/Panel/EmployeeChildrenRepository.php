<?php

namespace App\Repositories\Panel;

use App\Models\EmployeeChildren;

class EmployeeChildrenRepository extends EmployeeChildren
{

    /**
     * @param $employeeId
     */
    public function deleteByEmployee($employeeId)
    {
        $this->where([
            ['employeeId', '=', $employeeId]
        ])->delete();
    }

    public function createByEmployee($employeeId, $children)
    {
        $this->deleteByEmployee($employeeId);
        $this->insert($children);
    }

}