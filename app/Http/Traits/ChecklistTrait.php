<?php

namespace App\Http\Traits;

use App\Repositories\Panel\DocumentChecklistRepository;
use Illuminate\Http\Request;
use App\Repositories\Panel\DocumentRepository;
use App\Services\UploadService;
use App\Services\StringService;

trait ChecklistTrait
{

    use LogTrait;

    /**
     * @var array
     */
    private $extensions = ['pdf'];

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
     * @return mixed
     */
    protected function getPeriodicities()
    {
        return \Config::get('periodicities');
    }

    /**
     * @return int
     */
    protected function getEntityId()
    {
        return 0;
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return null;
    }

    /**
     * @param int $year
     * @param int $month
     * @param int $periodicity
     * @return mixed
     */
    protected function getDocuments($year, $month, $periodicity)
    {
        return [];
    }

    /**
     * @param null $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return [];
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
        return sprintf('%s/upload/documents/%s/%d/%d/%d/',
            storage_path(), $this->getEntityName(), $year, $month, $this->getEntityId()
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
            'periodicities' => $this->getPeriodicities(),
            'periodicity' => (int)$periodicity,
            'documents' => $this->getDocuments($year, $month, $periodicity),
            'breadcrumbs' => $this->getBreadcrumb('Checklist')
        ]);
    }

    /**
     * @param Request $request
     * @param DocumentChecklistRepository $documentChecklistRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(
        Request $request,
        DocumentChecklistRepository $documentChecklistRepository
    )
    {
        $upload = $this->upload($request);
        if (!$upload->error) {
            $documentChecklistRepository->createOrUpdate([
                'entityGroup' => 1,
                'entityId' => $this->getEntityId(),
                'documentId' => $request->get('documentId'),
                'referenceDate' => sprintf('%d-%d-01', $request->get('year'), $request->get('month')),
                'validity' => (int)$request->get('validity'),
                'status' => 1,
                'sentAt' => (new \DateTime())->format('Y-m-d H:i:s'),
                'fileName' => $upload->fileName,
                'originalFileName' => $upload->originalFileName
            ]);
        }

        $this->createLog('POST', (array)$upload);
        return response()->json($upload);
    }

    /**
     * @param Request $request
     * @return array|object
     */
    protected function upload(Request $request)
    {
        $document = (new DocumentRepository())->find($request->get('documentId'));
        $file = $request->file('file');
        $fileName = sprintf('%d-%s-%d-%d.pdf',
            $document->id,
            (new StringService())->toSlug($document->name),
            $request->get('month'),
            $request->get('year')
        );

        return (new UploadService())
            ->setDir($this->getDir($request->get('year'), $request->get('month')))
            ->setAllowedExtensions(
                $this->extensions, sprintf('S&oacute; &eacute; permitido arquivo: %s', implode($this->extensions))
            )->move(
                $file, $fileName, sprintf('O arquivo %s foi enviado com sucesso', $file->getClientOriginalName())
            );
    }

    /**
     * @param DocumentChecklistRepository $documentChecklistRepository
     * @param int $entityGroup
     * @param int $entityId
     * @param int $documentId
     * @param string $referenceDate
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(
        DocumentChecklistRepository $documentChecklistRepository,
        $entityGroup,
        $entityId,
        $documentId,
        $referenceDate
    )
    {
        $document = $documentChecklistRepository->findBy(
            $entityGroup, $entityId, $documentId, $referenceDate
        )->first();

        $year = $this->toReferenceDate($referenceDate, 'Y');
        $month = $this->toReferenceDate($referenceDate, 'm');

        $this->createLog('GET', ['downloadFile' => $document->fileName]);
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

        return redirect()->route(sprintf('checklist.%s.index', $this->getEntityName()), [
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

        return redirect()->route(sprintf('checklist.%s.index', $this->getEntityName()), [
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
        $this->createLog('POST', [
            'checklistStatus' =>  ($data['status'] === 3) ? 'disapprove' : 'approve',
            'referenceDate' => $this->toReferenceDate($request->get('referenceDate'), 'm/Y')
        ]);

        (new DocumentChecklistRepository())->findBy(
            $request->get('entityGroup'),
            $request->get('entityId'),
            $request->get('documentId'),
            $request->get('referenceDate')
        )->update($data);
    }

}