<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\ChecklistTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Services\BreadcrumbService;

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
        return 'Checklist clientes';
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return 1;
    }

    /**
     * @return int
     */
    protected function getEntityId()
    {
        return (\Session::has('company')) ? (int)\Session::get('company')->id : (int)\Auth::user()->companyId;
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return 'company';
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('company', $this->companyRepository->findById($id));
        return redirect()->route('checklist.company.index', [$this->getEntityGroup()]);
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
        return $this->breadcrumbService->push([
            'Clientes' => route('company.index'),
            'Checklist' => route('checklist.company.index', $parameters),
            $location => null
        ])->get();
    }

}
