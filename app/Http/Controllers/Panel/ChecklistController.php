<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;
use App\Services\UploadService;
use App\Services\StringService;

class ChecklistController extends Controller
{

    use LogTrait;

    /**
     * @var DocumentChecklistRepository
     */
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

    /**
     * @var array
     */
    private $status = [
        1 => 'Aguardando aprova&ccedil;&atilde;o',
        2 => 'Aprovado',
        3 => 'Reprovado'
    ];

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
            'status' => $this->status,
            'periodicities' => $this->periodicities,
            'periodicity' => (int)$periodicity,
            'documents' => $documents,
            'breadcrumbs' => $this->getBreadcrumb('Checklist')
        ]);
    }

    /**
     * @param string $referenceDate
     * @param string $format
     * @return string
     */
    protected function toReferenceDate($referenceDate, $format = 'Y-m-d')
    {
        $referenceDate = sprintf('01-%s', str_replace('/', '-', $referenceDate));
        return (new \DateTime($referenceDate))->format($format);
    }

    /**
     * @param string $referenceDate
     * @return string
     */
    protected function dir($referenceDate)
    {
        $referenceDate = $this->toReferenceDate($referenceDate, 'Y/m');
        return sprintf('%s/upload/documents/companies/%s/%d/',
            storage_path(), $referenceDate, $this->getCompanyId()
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $upload = $this->upload($request);
        if (!$upload->error) {
            $this->documentChecklistRepository->createOrUpdate([
                'entityGroup' => 1,
                'entityId' => $this->getCompanyId(),
                'documentId' => $request->get('documentId'),
                'referenceDate' => $this->toReferenceDate($request->get('referenceDate')),
                'validity' => (int)$request->get('validity'),
                'status' => 1,
                'sentAt' => (new \DateTime())->format('Y-m-d H:i:s'),
                'fileName' => $upload->fileName,
                'originalFileName' => $upload->originalFileName
            ]);
        }

        return response()->json($upload);
    }

    /**
     * @param Request $request
     * @return array|object
     */
    protected function upload(Request $request)
    {
        $document = $this->documentRepository->find($request->get('documentId'));
        $file = $request->file('file');
        $fileName = sprintf('%d-%s-%s.pdf',
            $document->id,
            $this->stringService->toSlug($document->name),
            $this->toReferenceDate($request->get('referenceDate'), 'm-Y')
        );

        return $this->uploadService
            ->setDir($this->dir($request->get('referenceDate')))
            ->setAllowedExtensions(
                $this->extensions, sprintf('S&oacute; &eacute; permitido arquivo: %s', implode($this->extensions))
            )->move(
                $file, $fileName, sprintf('O arquivo %s foi enviado com sucesso', $file->getClientOriginalName())
            );
    }

    /**
     * @param $entityGroup
     * @param $entityId
     * @param $documentId
     * @param $referenceDate
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($entityGroup, $entityId, $documentId, $referenceDate)
    {
        $document = $this->documentChecklistRepository->findBy(
            $entityGroup, $entityId, $documentId, $this->toReferenceDate($referenceDate)
        )->first();

        $path = sprintf('%s%s', $this->dir($referenceDate, $document->fileName));
        return response()->download($path);
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
