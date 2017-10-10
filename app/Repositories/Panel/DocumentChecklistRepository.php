<?php

namespace App\Repositories\Panel;

use App\Models\DocumentChecklist;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentChecklistRepository extends DocumentChecklist
{
    /**
     * @var int
     */
    protected $totalPerPage = 20;

    /**
     * @param int $entityGroup
     * @param int $entityId
     * @param int $documentId
     * @param string $referenceDate
     * @return $this
     */
    public function findBy($entityGroup, $entityId, $documentId, $referenceDate)
    {
        try {
            return $this->where([
                ['entityGroup', '=', $entityGroup],
                ['entityId', '=', $entityId],
                ['documentId', '=', $documentId],
                ['referenceDate', '=', $referenceDate],
            ]);
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param array $data
     */
    public function createOrUpdate($data)
    {
        try {
            $repository = $this->findBy(
                $data['entityGroup'],
                $data['entityId'],
                $data['documentId'],
                $data['referenceDate']
            );

            if ($repository->count() > 0) {
                $data['resentAt'] = $data['sentAt'];
                unset($data['sentAt']);
                $repository->update($data);
            } else {
                $this->create($data);
            }
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}