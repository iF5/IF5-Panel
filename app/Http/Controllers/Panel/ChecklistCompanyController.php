<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\ChecklistTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Services\BreadcrumbService;
use App\Facades\Company;

class ChecklistCompanyController extends Controller
{

    use ChecklistTrait;

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
     * ChecklistController constructor.
     * @param DocumentChecklistRepository $documentChecklistRepository
     * @param CompanyRepository $companyRepository
     * @param DocumentRepository $documentRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        DocumentChecklistRepository $documentChecklistRepository,
        CompanyRepository $companyRepository,
        DocumentRepository $documentRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->documentChecklistRepository = $documentChecklistRepository;
        $this->companyRepository = $companyRepository;
        $this->documentRepository = $documentRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Checklist de clientes';
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return Company::ID;
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return Company::LABEL;
    }

    /**
     * @return int
     */
    protected function getEntityId()
    {
        return Company::getCurrentId();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        Company::persist($this->companyRepository->findById($id));
        return redirect()->route('checklist.company.index', [1]);
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
            $periodicity, $this->getEntityGroup(), $this->companyRepository->findDocuments($this->getEntityId())
        );
    }

    /**
     * @param array $parameters
     * @param null $location
     * @return object
     */
    protected function getBreadcrumb($parameters = [], $location = null)
    {
        $company = Company::getCurrent();
        return $this->breadcrumbService->push([
            'Clientes' => route('company.index'),
            $company->fantasyName => route('company.show', [$company->id]),
            'Checklist de documentos' => route('checklist.company.index', $parameters),
            $location => null
        ])->get();
    }

}
