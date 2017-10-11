<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use Illuminate\Http\Request;
use App\Repositories\Panel\DocumentRepository;
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
        0 => 'Aguardando envio',
        1 => 'Aguardando aprova&ccedil;&atilde;o',
        2 => 'Aprovado',
        3 => 'Reprovado'
    ];

    /**
     * ChecklistController constructor.
     * @param DocumentChecklistRepository $documentChecklistRepository
     * @param CompanyRepository $companyRepository
     * @param DocumentRepository $documentRepository
     * @param BreadcrumbService $breadcrumbService
     * @param StringService $stringService
     * @param UploadService $uploadService
     */
    public function __construct(
        DocumentChecklistRepository $documentChecklistRepository,
        CompanyRepository $companyRepository,
        DocumentRepository $documentRepository,
        BreadcrumbService $breadcrumbService,
        StringService $stringService,
        UploadService $uploadService
    )
    {
        $this->documentChecklistRepository = $documentChecklistRepository;
        $this->companyRepository = $companyRepository;
        $this->documentRepository = $documentRepository;
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
        return redirect()->route('checklist.company.index', [1]);
    }

    /**
     * @return mixed
     */
    protected function getCompanyId()
    {
        return (\Session::has('company')) ? \Session::get('company')->id : \Auth::user()->companyId;
    }

    /**
     * @param string $referenceDate
     * @param string $format
     * @return string
     */
    protected function toReferenceDate($referenceDate, $format = 'Y-m-d')
    {
        $referenceDate = str_replace('/', '-', $referenceDate);
        if(strlen($referenceDate) < 10){
            $referenceDate = sprintf('01-%s', $referenceDate);
        }

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

        return response()->download(
            $this->dir($referenceDate) . $document->fileName
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request)
    {
        $this->update($request, [
            'status' => 2,
            'approvedAt' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('checklist.company.index', [
            $request->get('periodicity'),
            'referenceDate' => $this->toReferenceDate($request->get('referenceDate'), 'm/Y')
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disapprove(Request $request)
    {
        $this->update($request, [
            'status' => 3,
            'observation' => $request->get('observation'),
            'approvedAt' => null,
            'reusedAt' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('checklist.company.index', [
            $request->get('periodicity'),
            'referenceDate' => $this->toReferenceDate($request->get('referenceDate'), 'm/Y')
        ]);
    }

    /**
     * @param Request $request
     * @param array $data
     */
    protected function update(Request $request, $data)
    {
        $this->documentChecklistRepository->findBy(
            $request->get('entityGroup'),
            $request->get('entityId'),
            $request->get('documentId'),
            $request->get('referenceDate')
        )->update($data);
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
