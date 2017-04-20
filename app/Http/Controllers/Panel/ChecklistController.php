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

        $documentStruct = $this->documentStruct();
        $this->activeTab($documentStruct);

        //dd($documentStruct);

        return view('panel.checklist.index',  $documentStruct);
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

    public function upload(Request $request){
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $this->extensions)) {
            return response()->json([
                'message' => 'Só são permitidos arquivos do tipo ' . implode(', ', $this->extensions) . '.'
            ]);
        }

        $dir = storage_path() . '/upload/documents/';
        $name = sprintf('%s.%s', sha1(1), $extension);
        $isMoved = $file->move($dir, $name);
        if (!$isMoved) {
            return response()->json([
                'message' => "Falha ao enviar o arquivo <b>{$file->getClientOriginalName()}</b> por favor tente novamente!"
            ]);
        }

        /*$this->userRepository->find($this->getId())->update(['image' => $name]);*/
        return response()->json([
            'message' => "O arquivo <b>{$file->getClientOriginalName()}</b> foi enviado com sucesso!"
        ]);
    }

    private function documentStruct()
    {
        $struct['employee'] = $this->employee;
        $struct['documents']     = $this->documents;
        return $struct;
    }

}
