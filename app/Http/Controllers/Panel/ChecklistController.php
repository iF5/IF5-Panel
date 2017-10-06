<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use Illuminate\Http\Request;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;
use App\Services\UploadService;
use App\Services\StringService;

class ChecklistController extends Controller
{

    use LogTrait;

    private $documentChecklistRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

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

    /**
     * @var UploadService
     */
    private $uploadService;

    /**
     * @var StringService
     */
    private $stringService;

    /**
     * @var array
     */
    private $extensions = ['pdf'];

    /**
     * @var array
     */
    private $periodicities;

    public function __construct(
        DocumentChecklistRepository $documentChecklistRepository,
        CompanyRepository $companyRepository,
        DocumentRepository $documentRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService,
        StringService $stringService,
        UploadService $uploadService
    )
    {
        $this->documentChecklistRepository = $documentChecklistRepository;
        $this->companyRepository = $companyRepository;
        $this->documentRepository = $documentRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
        $this->uploadService = $uploadService;
        $this->stringService = $stringService;
        $this->periodicities = \Config::get('periodicities');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('company', $this->companyRepository->findById($id));
        return redirect()->route('checklist.company.index', ['periodicity' => 1]);
    }

    /**
     * @return mixed
     */
    protected function getCompanyId()
    {
        return (\Session::has('company')) ? \Session::get('company')->id : \Auth::user()->companyId;
    }

    /**
     * @param Request $request
     * @param $periodicity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $periodicity)
    {
        $referenceDate = $request->input('referenceDate');
        if ($referenceDate) {
            $documents = $this->documentRepository->findByReferenceDate($referenceDate, $periodicity, 1);
        } else {
            $documents = $this->documentRepository->findByPeriodicity(
                $periodicity, 1, $this->companyRepository->findDocuments($this->getCompanyId())
            );
        }

        return view('panel.checklist.index', [
            'referenceDate' => $referenceDate,
            'periodicities' => $this->periodicities,
            'periodicity' => (int)$periodicity,
            'documents' => $documents,
            'breadcrumbs' => $this->getBreadcrumb('Checklist')
        ]);
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $documentId
     * @return string
     */
    protected function dir($year, $month, $documentId)
    {
        return sprintf('%s/upload/documents/companies/%d/%d/%d/%d/',
            storage_path(), $year, $month, $this->getCompanyId(), $documentId
        );
    }


    public function store(Request $request)
    {
        $referenceDate = $request->get('referenceDate');
        $year = substr($referenceDate, 3, 4);
        $month = substr($referenceDate, 0, 2);
        $file = $request->file('file');

        $data = [
            'entityGroup' => 1,
            'entityId' => $this->getCompanyId(),
            'documentId' => $request->get('documentId'),
            'referenceDate' => sprintf('%d-%d-01', $year, $month),
            'validity' => (int)$request->get('validity'),
            'status' => 1,
            'sentAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'fileName',
            'originalFileName' => $file->getClientOriginalName()
        ];

    }

    protected function upload(Request $request, $year, $month)
    {
        $year = substr('09/2017', 3, 4);
        $month = substr('09/2017', 0, 2);
        $documentId = 1;
        $file = $request->file('file');

        $upload = $this->uploadService
            ->setDir($this->dir($year, $month, $request->get('documentId')))
            ->setAllowedExtensions(
                $this->extensions,
                sprintf('S&oacute; &eacute; permitido arquivo: %s', implode($this->extensions))
            )->move($file, $this->stringService->toSlug('Test ação.pdf'));

        $upload->message = '';
        return response()->json($upload);
    }

    public function uploadlala(Request $request, $documentId, $referenceDate)
    {

        $referenceDate = $referenceDate . "-01";

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

        $finalFileName = sha1($employeeId . "-" . $documentId . "-" . $referenceDate);
        $originalFileName = $file->getClientOriginalName();

        $dir = storage_path() . "/upload/documents/{$providerId}/{$employeeId}/{$documentId}/{$date['year']}/{$date['month']}";
        if (!file_exists($dir)) {
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

        $this->createLog('Checklist upload', 'PUT', $documentData);
        $this->documentRepository->saveDocument($documentData);
        return response()->json([
            'message' => "O arquivo <b>{$originalFileName}</b> foi enviado com sucesso!"
        ]);
    }


    /**
     * @param null $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            'Clientes' => route('company.index'),
            $location => null
        ])->get();
    }

}
