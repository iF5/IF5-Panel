<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\ChecklistTrait;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Services\BreadcrumbService;
use App\Facades\Provider;

class ChecklistProviderController extends Controller
{

    use ChecklistTrait;

    /**
     * @var DocumentChecklistRepository
     */
    private $documentChecklistRepository;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * ChecklistProviderController constructor.
     * @param DocumentChecklistRepository $documentChecklistRepository
     * @param ProviderRepository $providerRepository
     * @param DocumentRepository $documentRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        DocumentChecklistRepository $documentChecklistRepository,
        ProviderRepository $providerRepository,
        DocumentRepository $documentRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->documentChecklistRepository = $documentChecklistRepository;
        $this->providerRepository = $providerRepository;
        $this->documentRepository = $documentRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Checklist prestadores de servi&ccedil;os';
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return Provider::ID;
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return Provider::LABEL;
    }

    /**
     * @return int
     */
    protected function getEntityId()
    {
        return Provider::getCurrentId();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        Provider::persist($this->providerRepository->findById($id));
        return redirect()->route('checklist.provider.index', [1]);
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
            return $this->documentChecklistRepository->findByDocument(
                sprintf('%d-%d-01', $year, $month), $periodicity, $this->getEntityGroup()
            );
        }

        return $this->documentRepository->findByChecklist(
            $periodicity, $this->getEntityGroup(), $this->providerRepository->findDocuments($this->getEntityId())
        );
    }

    /**
     * @param array $parameters
     * @param null $location
     * @return object
     */
    protected function getBreadcrumb($parameters = [], $location = null)
    {
        return $this->breadcrumbService->push([
            'Clientes' => route('company.index'),
            'Prestadores de serviços' => route('provider.index'),
            'Checklist' => route('checklist.company.index', $parameters),
            $location => null
        ])->get();
    }

}
