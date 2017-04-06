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
     *
     * @param $source
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($source)
    {
        if ($source === 'provider') {
            return view('panel.pendency.list', [
                'source' => $source,
                'data' => $this->providerRepository->findByPendency(),
                'breadcrumbs' => $this->getBreadcrumb($source, self::PROVIDER_TITLE)
            ]);
        }

        return view('panel.pendency.list', [
            'source' => $source,
            'data' => $this->employeeRepository->findByPendency(),
            'breadcrumbs' => $this->getBreadcrumb($source, self::EMPLOYEE_TITLE)
        ]);
    }


    public function show($companyId, $id, $source)
    {
        if ($source === 'provider') {
            return view('panel.provider.show', [
                'provider' => $this->providerRepository->findByCompany($id, $companyId),
                'breadcrumbs' => $this->getBreadcrumb($source, self::PROVIDER_TITLE)
            ]);
        }

        return view('panel.employee.show', [
            'employee' => $this->employeeRepository->findById($id),
            'breadcrumbs' => $this->getBreadcrumb($source, self::EMPLOYEE_TITLE)
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
            $this->relationshipRepository->update('companies_has_providers', ['status' => 1], [
                'companyId' => $companyId,
                'providerId' => $id
            ]);
            return redirect()->route('pendency.index', ['source' => $source]);
        }

        $this->employeeRepository->find($id)->update(['status' => 1]);
        return redirect()->route('pendency.index', ['source' => $source]);
    }

    /**
     * @param string $source
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($source, $location = null)
    {
        return $this->breadcrumbService
            ->add('Pend&ecirc;ncias', route('pendency.index', ['source' => $source]))
            ->add($location, null, true)
            ->get();
    }
}
