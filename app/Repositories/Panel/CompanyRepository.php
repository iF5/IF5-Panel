<?php

namespace App\Repositories\Panel;

use App\Models\Company;

class CompanyRepository extends Company
{

    protected $totalPerPage = 2;

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

}