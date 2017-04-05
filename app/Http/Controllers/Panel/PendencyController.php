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
            'breadcrumbs' => $this->getBreadcrumb('pendency.provider', self::PROVIDER_TITLE)
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
        if ($source === 'provider') {
            return view('panel.provider.show', [
                'provider' => $this->providerRepository->findByCompany($id, $companyId),
                'breadcrumbs' => $this->getBreadcrumb('pendency.provider', self::PROVIDER_TITLE)
            ]);
        }

        return view('panel.employee.show', [
            'employee' => $this->employeeRepository->findById($id),
            'breadcrumbs' => $this->getBreadcrumb('pendency.employee', self::EMPLOYEE_TITLE)
        ]);
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
     * @param string $route
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($route = null, $location = null)
    {
        return $this->breadcrumbService
            ->add('Pend&ecirc;ncias', route($route))
            ->add($location, null, true)
            ->get();
    }
}
