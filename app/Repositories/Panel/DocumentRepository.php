<?php

namespace App\Repositories\Panel;

use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentRepository extends Document
{
    protected $totalPerPage = 20;

    private $initialDate;

    private $finalDate;

    private function rangeDates()
    {
        $preDate = date("Y-m");
        $this->initialDate = $preDate . "-01";
        $this->finalDate = $preDate . "-31";
    }

    private function getDocTypeField($docTypeId)
    {
        $fields = array(1 => "isMonthly", 2 => "isYearly", 3 => "isSolicited", 4 => "isHomologated", 5=> "isSemester");

        return $fields[$docTypeId];
    }

    public function getAllDocuments()
    {
        try {
            return Document::where([
                ['provider', '=', 0]
            ])->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }


    /**
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findByEmployee($id, $docTypeId)
    {
        try {
            $this->rangeDates();
            $docTypeField = $this->getDocTypeField($docTypeId);

            return DB::select(DB::raw("SELECT d.*, ehd.* FROM documents as d
                                LEFT JOIN employees_has_documents as ehd ON
                                d.id = ehd.documentId AND
                                referenceDate >= '$this->initialDate' AND referenceDate <= '$this->finalDate'  AND ehd.employeeId = $id
                                LEFT JOIN employees as e ON
                                e.id = ehd.employeeId
                                WHERE
                                d.$docTypeField = 1
                                ORDER BY d.id;"));

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }
}