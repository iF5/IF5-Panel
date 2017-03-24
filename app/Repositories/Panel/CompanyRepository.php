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
        return Company::where($field, 'like', "%{$keyword}%")
            ->paginate($this->totalPerPage);
    }

    /**
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($field = 'id', $type = 'desc')
    {
        return Company::orderBy($field, $type)
            ->paginate($this->totalPerPage);
    }

    /**
     * @param int $id
     * @param string $field
     * @return mixed
     */
    public function getName($id, $field = 'name')
    {
        return Company::where('id', '=', $id)
            ->pluck($field)
            ->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        try {
            return (object)Company::find($id)->original;
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}