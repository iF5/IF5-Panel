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
            return Company::where($field, 'like', "%{$keyword}%")->paginate($this->totalPerPage);
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
            return Company::orderBy($field, $type)->paginate($this->totalPerPage);
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
            return Company::where('id', '=', $id)->pluck($field)->first();
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
            return (object)Company::find($id)->original;
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

}