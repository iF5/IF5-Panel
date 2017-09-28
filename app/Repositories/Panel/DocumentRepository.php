<?php

namespace App\Repositories\Panel;

use App\Models\Document;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentRepository extends Document
{
    /**
     * @var int
     */
    protected $totalPerPage = 20;

    /**
     * @param int $entityGroup
     * @param string $field
     * @param null | string $keyword
     * @return mixed
     */
    public function findLike($entityGroup, $field, $keyword = null)
    {
        try {
            return $this->where([
                ['entityGroup', '=', $entityGroup],
                [$field, 'like', "%{$keyword}%"],
            ])->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $entityGroup
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($entityGroup, $field = 'id', $type = 'desc')
    {
        try {
            return $this->where([
                ['entityGroup', '=', $entityGroup]
            ])->orderBy($field, $type)->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $entityGroup
     * @return mixed
     */
    public function findAllByEntity($entityGroup)
    {
        try {
            return $this->where([
                ['entityGroup', '=', $entityGroup]
            ])->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}