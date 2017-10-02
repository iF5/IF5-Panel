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

    /**
     * @param int $periodicity
     * @param int $entityGroup
     * @param array $documents
     * @return mixed
     */
    public function findByPeriodicity($periodicity, $entityGroup, array $documents = [])
    {
        try {
            return $this->where([
                ['periodicity', '=', $periodicity],
                ['entityGroup', '=', $entityGroup]
            ])->whereIn('id', $documents)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $periodicity
     * @param string $referenceDate
     * @param int $entityGroup
     * @return mixed
     */
    public function findByReferenceDate($referenceDate, $periodicity, $entityGroup)
    {
        try {
            return $this->join('document_checklists', function ($join) {
                return $join->on('document_checklists.documentId', '=', 'documents.id');
            })->where([
                ['documents.periodicity', '=', $periodicity],
                ['documents.entityGroup', '=', $entityGroup],
                ['document_checklists.referenceDate', '=', sprintf('%s-%s-01',
                    substr($referenceDate, 3, 4),
                    substr($referenceDate, 0, 2)
                )]
            ])->get();

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }


}