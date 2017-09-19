<?php

namespace App\Repositories\Panel;

use App\Models\Report;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReportRepository extends Report
{

    protected $totalPerPage = 20;

    /**
     * @param $companyId
     * @param null $referenceDate
     * @return mixed
     */
    public function findByReferenceDate($companyId, $referenceDate = null)
    {
        try {
            return Report::where([
                ['companyId', '=', $companyId],
                ['referenceDate' , '=', $referenceDate]
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
            return Report::where('companyId', '=', $companyId)
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
            return (object)Report::find($id)->original;
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}