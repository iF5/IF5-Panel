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
        if (strlen($referenceDate) < 10) {
            $referenceDate = sprintf('01-%s', $referenceDate);
        }

        return (new \DateTime($referenceDate))->format($format);
    }

    /**
     * @param int $year
     * @param int $month
     * @return string
     */
    protected function getDir($year, $month)
    {
        return sprintf('%s/upload/documents/company/%d/%d/%d/',
            storage_path(), $year, $month, $this->getCompanyId()
        );
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $periodicity
     * @return mixed
     */
    protected function getDocuments($year, $month, $periodicity)
    {
        if ($year && $month) {
            return $this->documentChecklistRepository->findDocumentByChecklist(
                sprintf('%d-%d-01', $year, $month), $periodicity, 1
            );
        }

        return $this->documentRepository->findByChecklist(
            $periodicity, 1, $this->companyRepository->findDocuments($this->getCompanyId())
        );
    }

    /**
     * @param Request $request
     * @param $periodicity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $periodicity)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        return view('panel.checklist.index', [
            'year' => $year,
            'month' => $month,
            'status' => $this->status,
            'periodicities' => $this->periodicities,
            'periodicity' => (int)$periodicity,
            'documents' => $this->getDocuments($year, $month, $periodicity),
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
                'referenceDate' => sprintf('%d-%d-01', $request->get('year'), $request->get('month')),
                'validity' => (int)$request->get('validity'),
                'status' => 1,
                'sentAt' => (new \DateTime())->format('Y-m-d H:i:s'),
                'fileName' => $upload->fileName,
                'originalFileName' => $upload->originalFileName
            ]);
        }

        return response()->json($upload);
    }

    public function showPdf()
    {

        ///src/IF5-Panel/storage/upload/documents/company/2017/10/1/11-teste-10-2017.pdf
        //11-teste-10-2017.pdf
        //$pdf = sprintf('%s11-teste-10-2017.pdf', $this->getDir(2017, 10));

        $pdf = sprintf('%s/../storage/upload/documents/company/2017/11/2/2-termo-de-responsabilidade-e-uso-da-informacao-11-2017.pdf', url('/'));


        return view('panel.checklist.show', [
            'pdf' => $pdf,
            'breadcrumbs' => $this->getBreadcrumb('Checklist')
        ]);
    }

    /**
     * @param Request $request
     * @return array|object
     */
    protected function upload(Request $request)
    {
        $document = $this->documentRepository->find($request->get('documentId'));
        $file = $request->file('file');
        $fileName = sprintf('%d-%s-%d-%d.pdf',
            $document->id,
            $this->stringService->toSlug($document->name),
            $request->get('month'),
            $request->get('year')
        );

        return $this->uploadService
            ->setDir($this->getDir($request->get('year'), $request->get('month')))
            ->setAllowedExtensions(
                $this->extensions, sprintf('S&oacute; &eacute; permitido arquivo: %s', implode($this->extensions))
            )->move(
                $file, $fileName, sprintf('O arquivo %s foi enviado com sucesso', $file->getClientOriginalName())
            );
    }

    /**
     * @param int $entityGroup
     * @param int $entityId
     * @param int $documentId
     * @param string $referenceDate
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($entityGroup, $entityId, $documentId, $referenceDate)
    {
        $document = $this->documentChecklistRepository->findBy(
            $entityGroup, $entityId, $documentId, $referenceDate
        )->first();

        $year = $this->toReferenceDate($referenceDate, 'Y');
        $month = $this->toReferenceDate($referenceDate, 'm');
        return response()->download(
            $this->getDir($year, $month) . $document->fileName
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
            'month' => $this->toReferenceDate($request->get('referenceDate'), 'm'),
            'year' => $this->toReferenceDate($request->get('referenceDate'), 'Y')
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
            'month' => $this->toReferenceDate($request->get('referenceDate'), 'm'),
            'year' => $this->toReferenceDate($request->get('referenceDate'), 'Y')
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
