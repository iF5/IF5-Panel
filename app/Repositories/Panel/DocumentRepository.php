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
     * @param int $isActive
     * @return mixed
     */
    public function findAllByEntity($entityGroup, $isActive = 1)
    {
        try {
            return $this->where([
                ['entityGroup', '=', $entityGroup],
                ['isActive', '=', $isActive]
            ])->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }


    /**
     * @param int $entityGroup
     * @return array
     */
    public function idList($entityGroup)
    {
        $list = [];
        $documents = $this->findAllByEntity($entityGroup);
        foreach ($documents as $document) {
            $list[] = $document->id;
        }
        return $list;
    }

    /**
     * @param int $periodicity
     * @param int $entityGroup
     * @param array $documents
     * @param int $isActive
     * @return mixed
     */
    public function findByChecklist($periodicity, $entityGroup, array $documents = [], $isActive = 1)
    {
        try {
            return $this->where([
                ['periodicity', '=', $periodicity],
                ['entityGroup', '=', $entityGroup],
                ['isActive', '=', $isActive]
            ])->whereIn('id', $documents)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}