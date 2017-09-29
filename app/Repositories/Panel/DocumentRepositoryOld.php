<?php

namespace App\Repositories\Panel;

use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentRepositoryOld extends Document
{
    protected $totalPerPage = 20;

    private $initialDate;

    private $finalDate;

    private function rangeDates($referenceDate = false)
    {
        if($referenceDate){
            if(preg_match('/[0-9]{2}\/[0-9]{4}/', $referenceDate)){
                $arrDate = explode("/", $referenceDate);
                $preDate = $arrDate[1] . "-" . $arrDate[0];
            }
        }else {
            $preDate = date("Y-m");
        }
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
            echo $e->getMessage();
            return false;
        }
    }


    /**
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findByEmployee($id, $docTypeId, $referenceDate)
    {
        try {
            $referenceDateQuery = "";
            if($docTypeId != 2) {
                $this->rangeDates($referenceDate);
                $referenceDateQuery = " AND referenceDate >= '$this->initialDate' AND referenceDate <= '$this->finalDate' ";
            }
            $docTypeField = $this->getDocTypeField($docTypeId);
            $sql = "SELECT d.*, ehd.* FROM documents as d
                                LEFT JOIN employees_has_documents as ehd ON
                                d.id = ehd.documentId
                                $referenceDateQuery AND ehd.employeeId = $id
                                LEFT JOIN employees as e ON
                                e.id = ehd.employeeId
                                WHERE
                                d.$docTypeField = 1
                                ORDER BY d.id;";
            dd($sql);
            return DB::select(DB::raw($sql));
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function saveDocument($data)
    {
        try {
            //return DB::table('employees_has_documents')->insert($data);
            DB::insert(DB::raw("INSERT INTO employees_has_documents
                            (employeeId, documentId, referenceDate, finalFileName, originalFileName)
                            VALUES(
                            ".$data['employeeId'].", " . $data['documentId'] . ",
                            '". $data['referenceDate'] ."', '" . $data['finalFileName'] . "', '" . $data['originalFileName'] . "'
                            ) ON DUPLICATE KEY UPDATE
                            referencedate='". $data['referenceDate']."',
                            reSendDate=current_timestamp(),
                            finalFileName='" . $data['finalFileName']. "',
                            originalFileName='" . $data['originalFileName'] . "' "));
        } catch(\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateDocument($data)
    {
        try {
            $arrUpdate = ['validated' => $data['status'], 'receivedDate' => date("Y-m-d H:i:s")];
            if($data['status'] == 0){
                $arrUpdate = ['validated' => $data['status']];
            }
            return DB::table('employees_has_documents')
                ->where('employeeId', $data['employeeId'])
                ->where('documentId', $data['documentId'])
                ->where('referenceDate', $data['referenceDate'])
                ->update($arrUpdate);
        } catch(\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}