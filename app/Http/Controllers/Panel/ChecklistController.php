<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\CompanyRepository;
use Illuminate\Http\Request;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;

class ChecklistController extends Controller
{

    use LogTrait;

    /**
     * @var EmployeeRepository
     */
    private $employeesRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    private $extensions = ['pdf'];

    /**
     * @var array
     */
    private $periodicities;

    public function __construct(
        EmployeeRepository $employeesRepository,
        CompanyRepository $companyRepository,
        DocumentRepository $documentRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->employeesRepository = $employeesRepository;
        $this->companyRepository = $companyRepository;
        $this->documentRepository = $documentRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
        $this->periodicities = \Config::get('periodicities');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('company', $this->companyRepository->findById($id));
        return redirect()->route('checklist-company.index', ['periodicity' => 1]);
    }

    /**
     * @return mixed
     */
    protected function getCompanyId()
    {
        return (\Session::has('company')) ? \Session::get('company')->id : \Auth::user()->companyId;
    }

    public function index(Request $request, $periodicity)
    {
        $referenceDate = \Request::input('referenceDate');

        return view('panel.checklist.index', [
            'periodicities' => $this->periodicities,
            'periodicityId' => (int)$periodicity,
            'documents' => $this->documentRepository->findByPeriodicity($periodicity, 1),
            'breadcrumbs' => $this->getBreadcrumb('Checklist')
        ]);
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
