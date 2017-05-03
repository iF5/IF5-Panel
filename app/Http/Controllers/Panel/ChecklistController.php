<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;

class ChecklistController
{

    /**
     * @var EmployeeRepository
     */
    private $employeesRepository;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    private $employee;

    private $documents;

    private $docTypeId;

    private $extensions = ['pdf'];

    public function __construct(
        EmployeeRepository $employeesRepository,
        DocumentRepository $documentRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->employeesRepository = $employeesRepository;
        $this->documentRepository = $documentRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    public function index($id, $docTypeId)
    {
        $this->docTypeId = $docTypeId;
        $this->employee = $this->employeesRepository->findById($id);
        $this->documents = $this->documentRepository->findByEmployee($id, $docTypeId);

        session(['employee' => $this->employee]);

        $documentStruct = $this->documentStruct();
        $this->activeTab($documentStruct);

        //dd($documentStruct);

        return view('panel.checklist.index',  $documentStruct);
    }

    private function documentStruct()
    {
        $struct['employee'] = $this->employee;
        $struct['documents']     = $this->documents;
        return $struct;
    }

    private function activeTab(&$struct)
    {
        $struct = array_merge($struct, array(
            "activeMontly" => "",
            "activeYearly" => "",
            "activeSolicited" => "",
            "activeHomologated" => "",
            "activeSemester" => ""
        ));
        switch($this->docTypeId){
            case 1:
                $struct['activeMontly'] = "active";
            break;
            case 2:
                $struct['activeYearly'] = "active";
            break;
            case 3:
                $struct['activeSolicited'] = "active";
            break;
            case 4:
                $struct['activeHomologated'] = "active";
            break;
            case 5:
                $struct['activeSemester'] = "active";
            break;
        }
    }

    public function upload(Request $request, $documentId, $referenceDate){

        $referenceDate = $referenceDate."-01";

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $this->extensions)) {
            return response()->json([
                'message' => 'Só são permitidos arquivos do tipo ' . implode(', ', $this->extensions) . '.'
            ]);
        }

        $date = $this->explodeDate($referenceDate);
        $employeeId = session('employee')->id;
        $providerId = session('provider')->id;

        $finalFileName = sha1($employeeId . "-" . $documentId . "-". $referenceDate);
        $originalFileName = $file->getClientOriginalName();

        $dir = storage_path() . "/upload/documents/{$providerId}/{$employeeId}/{$date['year']}/{$date['month']}";
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $finalFileName = sprintf('%s.%s', $finalFileName, $extension);
        $isMoved = $file->move($dir, $finalFileName);
        if (!$isMoved) {
            return response()->json([
                'message' => "Falha ao enviar o arquivo <b>{$originalFileName}</b> por favor tente novamente!"
            ]);
        }

        $documentData =
            ['employeeId' => $employeeId,
             'documentId' => $documentId,
             'status' => 1,
             'referenceDate' => $referenceDate,
             'finalFileName' => $finalFileName,
             'originalFileName' => $originalFileName];

        $this->documentRepository->saveDocument($documentData);
        return response()->json([
            'message' => "O arquivo <b>{$originalFileName}</b> foi enviado com sucesso!"
        ]);
    }

    public function update($employeeId, $documentId, $referenceDate, $status)
    {
        //dd("$employeeId - $documentId - $referenceDate");
        $documentData = [
            'employeeId' => $employeeId,
            'documentId' => $documentId,
            'referenceDate' => $referenceDate,
            'status' => $status
        ];
        if($this->documentRepository->updateDocument($documentData)) {
            $return = array("status" => "success");
        }else{
            $return = array("status" => "fail");
        }
        return json_encode($return);
    }

    public function download($employeeId, $referenceDate, $finalFileName)
    {
        $date = $this->explodeDate($referenceDate);
        $providerId = session('provider')->id;

        $path = storage_path() . "/upload/documents/{$providerId}/{$employeeId}/{$date['year']}/{$date['month']}/{$finalFileName}";
        return response()->download($path);
    }

    private function explodeDate($date){
        $arrayDate = array("year" => "", "month" => "", "day" => "");
        $explodeData = explode("-", $date);
        $arrayDate['year'] = (key_exists(0, $explodeData)) ?  $explodeData[0]: "";
        $arrayDate['month'] = (key_exists(1, $explodeData)) ?  $explodeData[1]: "";
        $arrayDate['day'] = (key_exists(2, $explodeData)) ?  $explodeData[2]: "";
        return $arrayDate;
    }

}
