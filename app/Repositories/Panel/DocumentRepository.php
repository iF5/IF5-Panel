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
        return $this->findWhere([
            ['entityGroup', '=', $entityGroup]
        ]);
    }

    /**
     * @param int $periodicityId
     * @param int $entityGroup
     * @return mixed
     */
    public function findByPeriodicity($periodicityId, $entityGroup)
    {
        return $this->findWhere([
            ['periodicity', '=', $periodicityId],
            ['entityGroup', '=', $entityGroup]
        ]);
    }

    /**
     * @param array $where
     * @param bool $toSql
     * @return mixed
     */
    public function findWhere(array $where = [], $toSql = false)
    {
        try {
            $stmt = $this->where($where);
            if ($toSql) {
                dd($stmt->toSql());
            }
            return $stmt->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}