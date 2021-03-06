<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

use App\Http\Traits\LogTrait;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;

class PendencyController extends Controller
{

    use LogTrait;

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
     * @return null
     */
    protected function logTitle()
    {
        return 'Aprova&ccedil;&atilde;o de pend&ecirc;ncias';
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
            'companies' => $this->employeeRepository->findAllByCompany($companyId),//Nesse caso $companyId e o providerId
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
            $this->relationshipRepository->update('providers_has_companies', ['status' => 1], [
                'companyId' => $companyId,
                'providerId' => $id
            ]);
        } else {
            $this->employeeRepository->find($id)->update(['status' => 1]);
        }

        $this->createLog('PUT', ["{$source}Id" => $id]);
        return redirect()->route('pendency.index', ['source' => $source]);
    }

    /**
     * @param string $source
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($source, $location = null)
    {
        return $this->breadcrumbService->push([
            'Pend&ecirc;ncias' => route('pendency.index', ['source' => $source]),
            $location => null
        ])->get();
    }
}
