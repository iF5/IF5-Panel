<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\ChecklistTrait;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\DocumentChecklistRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Services\BreadcrumbService;
use App\Facades\Employee;
use App\Facades\Company;
use App\Facades\Provider;

class ChecklistEmployeeController extends Controller
{

    use ChecklistTrait;

    /**
     * @var DocumentChecklistRepository
     */
    private $documentChecklistRepository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;


    public function __construct(
        DocumentChecklistRepository $documentChecklistRepository,
        EmployeeRepository $employeeRepository,
        DocumentRepository $documentRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->documentChecklistRepository = $documentChecklistRepository;
        $this->employeeRepository = $employeeRepository;
        $this->documentRepository = $documentRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Checklist de funcion&aacute;rios';
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return Employee::ID;
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return Employee::LABEL;
    }

    /**
     * @return int
     */
    protected function getEntityId()
    {
        return Employee::getCurrentId();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        Employee::persist($this->employeeRepository->findById($id));
        return redirect()->route('checklist.employee.index', [1]);
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
            $periodicity, $this->getEntityGroup(), $this->employeeRepository->listIdDocuments($this->getEntityId())
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
        $provider = Provider::getCurrent();
        $data = [];
        if ($company && $provider) {
            $data = [
                'Clientes' => route('company.index'),
                $company->fantasyName => route('company.show', $company->id),
                'Prestadores de servi&ccedil;os' => route('provider.index'),
                $provider->fantasyName => route('provider.show', $provider->id)
            ];
        }

        return $this->breadcrumbService->push(array_merge($data, [
            'Funcion&aacute;rios' => route('employee.index'),
            'Checklist de documentos' => route('checklist.company.index', $parameters),
            $location = null
        ]))->get();
    }

}
