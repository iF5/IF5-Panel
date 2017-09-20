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
     * @param string $field
     * @param string|null $keyword
     * @return mixed
     */
    public function findLike($field, $keyword = null)
    {
        try {
            return $this->where($field, 'like', "%{$keyword}%")->paginate($this->totalPerPage);
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
            return $this->orderBy($field, $type)->paginate($this->totalPerPage);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }
}