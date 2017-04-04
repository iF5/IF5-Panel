<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;

class PendencyController extends Controller
{

    const PROVIDER_TITLE = 'Prestadores de servi&ccedil;os';

    const EMPLOYEE_TITLE = 'Funcion&aacute;rios';

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    public function __construct(
        ProviderRepository $providerRepository,
        EmployeeRepository $employeeRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->providerRepository = $providerRepository;
        $this->employeeRepository = $employeeRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * Display a listing of the resource.
     */
    public function provider()
    {
        $providers = $this->providerRepository->findByPendency();

        return view('panel.pendency.list', [
            'route' => 'pendency.provider',
            'source' => 'provider',
            'keyword' => null,
            'data' => $providers,
            'breadcrumbs' => $this->getBreadcrumb(self::PROVIDER_TITLE)
        ]);
    }

    public function employee()
    {
        $employees = $this->employeeRepository->findByPendency();

        return view('panel.pendency.list', [
            'route' => 'pendency.employee',
            'source' => 'employee',
            'keyword' => null,
            'data' => $employees,
            'breadcrumbs' => $this->getBreadcrumb(self::EMPLOYEE_TITLE)
        ]);
    }

    public function show($companyId, $id, $source)
    {
        if($source === 'provider'){
            return view('panel.pendency.show', $this->getDataProvider($companyId, $id));
        }

        return view('panel.pendency.show', $this->getDataEmployee($companyId, $id));
    }

    protected function getDataProvider($companyId, $id)
    {
        $provider = $this->providerRepository->findById($id);
        return [
            'route' => 'pendency.provider',
            'id' => $provider->id,
            'companyId' => $companyId,
            'source' => 'provider',
            'data' => [
                'Nome' => $provider->name,
                'CNPJ' => $provider->cnpj
            ],
            'breadcrumbs' => $this->getBreadcrumb(self::PROVIDER_TITLE)
        ];
    }

    protected function getDataEmployee($companyId, $id)
    {
        $employee = $this->employeeRepository->findById($id);
        return [
            'route' => 'pendency.employee',
            'id' => $employee->id,
            'companyId' => $companyId,
            'source' => 'employee',
            'data' => [
                'Nome' => $employee->name,
                'CPF' => $employee->cpf
            ],
            'breadcrumbs' => $this->getBreadcrumb(self::EMPLOYEE_TITLE)
        ];
    }

    /**
     * @param int $companyId
     * @param int $id
     * @param string $source
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($companyId, $id, $source)
    {
        if ($source === 'provider') {
            $this->approveProvider($companyId, $id);
            return redirect()->route('pendency.provider');
        }

        $this->approveEmployee($companyId, $id);
        return redirect()->route('pendency.employee');

    }

    /**
     * @param int $companyId
     * @param int $providerId
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function approveProvider($companyId, $providerId)
    {
        $this->relationshipRepository->update('companies_has_providers', ['status' => 1], [
            'companyId' => $companyId,
            'providerId' => $providerId
        ]);
    }

    /**
     * @param int $companyId
     * @param int $employeeId
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function approveEmployee($companyId, $employeeId)
    {
        $this->relationshipRepository->update('employees_has_companies', ['status' => 1], [
            'employeeId' => $employeeId,
            'companyId' => $companyId
        ]);
    }


    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService
            ->add('Pend&ecirc;ncias', route('pendency.provider'))
            ->add($location, null, true)
            ->get();
    }
}
