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

    public function index(Request $request, $id, $docTypeId)
    {
        $this->referenceDate = $request->input('referenceDateSearch');

        $this->docTypeId = $docTypeId;
        $this->employee = $this->employeesRepository->findById($id);
        $this->documents = $this->documentRepository->findByEmployee($id, $docTypeId, $this->referenceDate);

        session(['employee' => $this->employee]);

        $documentStruct = $this->documentStruct();
        $this->activeTab($documentStruct);

        //dd($documentStruct);

        return view('panel.checklist.index',  $documentStruct);
    }

    private function documentStruct()
    {
        $struct['employee'] = $this->employee;
        $struct['docTypeId'] = $this->docTypeId;
        $struct['documents']     = $this->documents;
        $struct['referenceDate'] = $this->referenceDate ? $this->referenceDate : "";
        $struct['breadcrumbs'] = $this->getBreadcrumb();
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

    public function upload(Request $request, $documentId, $referenceDate)
    {

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
        $providerId = session('provider') ? session('provider')->id : \Auth::user()->providerId;

        $finalFileName = sha1($employeeId . "-" . $documentId . "-". $referenceDate);
        $originalFileName = $file->getClientOriginalName();

        $dir = storage_path() . "/upload/documents/{$providerId}/{$employeeId}/{$documentId}/{$date['year']}/{$date['month']}";
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

    public function download($employeeId, $documentId, $referenceDate, $finalFileName)
    {
        $date = $this->explodeDate($referenceDate);
        $providerId = session('provider') ? session('provider')->id : \Auth::user()->providerId;

        $path = storage_path() . "/upload/documents/{$providerId}/{$employeeId}/{$documentId}/{$date['year']}/{$date['month']}/{$finalFileName}";
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

    protected function getBreadcrumb()
    {
        if (\Session::has('company')) {
            $company = \Session::get('company');
            $data = [
                'Clientes' => route('company.index'),
                $company->name => route('company.show', $company->id)
            ];
        }

        if (\Session::has('provider')) {
            $provider = \Session::get('provider');
            $data['Prestadores de servi&ccedil;os'] = route('provider.index');
            $data[$provider->name] = route('provider.show', $provider->id);
        }

        $data['Funcion&aacute;rios'] = route('employee.index');
        $data['Documentos'] = null;

        return $this->breadcrumbService->push($data)->get();
    }

}
