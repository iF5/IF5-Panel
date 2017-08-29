<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\AuthTrait;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{

    use AuthTrait, LogTrait;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * @var array
     */
    private $states;

    public function __construct(
        EmployeeRepository $employeeRepository,
        RelationshipRepository $relationshipRepository,
        ProviderRepository $providerRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->providerRepository = $providerRepository;
        $this->breadcrumbService = $breadcrumbService;
        $this->states = \Config::get('states');

    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('provider', $this->providerRepository->findById($id));
        return redirect()->route('employee.index');
    }

    /**
     * @return int
     */
    protected function getProviderId()
    {
        return (in_array(\Auth::user()->role, ['admin', 'company']))
            ? \Session::get('provider')->id
            : \Auth::user()->providerId;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $employees = ($keyword)
            ? $this->employeeRepository->findLike($this->getProviderId(), 'name', $keyword)
            : $this->employeeRepository->findOrderBy($this->getProviderId());

        return view('panel.employee.list', [
            'keyword' => $keyword,
            'breadcrumbs' => $this->getBreadcrumb(),
            'employees' => $employees
        ]);
    }

    protected function formRequest($data, $action = null)
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        if ($action === 'store') {
            $data['createdAt'] = $now;
        }
        $data['updatedAt'] = $now;
        $data['salaryCap'] = str_replace(['.', ','], ['', '.'], $data['salaryCap']);
        //$data['salaryCap'] = number_format($data['salaryCap'], 2, ',', '');
        $data['status'] = $this->isAdmin();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->employeeRepository->providerId = $this->getProviderId();
        $this->employeeRepository->hasChildren = 0;
        $companies = $this->getCompanies();

        return view('panel.employee.form', [
            'employee' => $this->employeeRepository,
            'states' => $this->states,
            'companies' => $companies,
            'route' => 'employee.store',
            'method' => 'POST',
            'parameters' => [],
            'breadcrumbs' => $this->getBreadcrumb('Cadastrar')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request, $this->employeeRepository->validateRules(), $this->employeeRepository->validateMessages()
        );

        $data = $this->formRequest($request->all(), 'store');
        $employee = $this->employeeRepository->create($data);
        $this->createRelationshipByCompany($employee->id, $data['companies']);

        $this->createLog('Funcion&aacute;rio', 'POST', $data);

        return redirect()->route('employee.create')->with([
            'success' => true,
            'message' => 'Funcion&aacute;rio cadastrado com sucesso!',
            'route' => 'employee.show',
            'id' => $employee->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->employeeRepository->find($id);
        $companies = $this->employeeRepository->findCompanyByProvider($this->getProviderId());

        return view('panel.employee.show', [
            'employee' => $employee,
            'companies' => $companies,
            'breadcrumbs' => $this->getBreadcrumb('Visualizar')
        ]);
    }

    /**
     * @param int $employeeId
     * @return mixed
     */
    private function getCompanies($employeeId = null)
    {
        $companies = $this->employeeRepository->findCompanyByProvider($this->getProviderId());
        $employeesArray = [];

        if ($employeeId) {
            $employees = $this->employeeRepository->findCompanyByEmployee($employeeId);
            foreach ($employees as &$employee) {
                $employeesArray[] = $employee->companyId;
            }
        }

        foreach ($companies as &$company) {
            $company->selected = (in_array($company->id, $employeesArray)) ? true : false;
        }
        return $companies;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->employeeRepository->findOrFail($id);
        $companies = $this->getCompanies($id);
        #dd($employee);
        return view('panel.employee.form', [
            'employee' => $employee,
            'states' => $this->states,
            'companies' => $companies,
            'route' => 'employee.update',
            'method' => 'PUT',
            'parameters' => [$id],
            'breadcrumbs' => $this->getBreadcrumb('Atualizar')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request, $this->employeeRepository->validateRules($id), $this->employeeRepository->validateMessages()
        );

        $data = $this->formRequest($request->all());
        $this->employeeRepository->findOrFail($id)->update($data);
        $this->createRelationshipByCompany($id, $data['companies']);

        $this->createLog('Funcion&aacute;rio', 'PUT', $data);

        return redirect()->route('employee.edit', $id)->with([
            'success' => true,
            'message' => 'Funcion&aacute;rio atualizado com sucesso!',
            'route' => 'employee.show',
            'id' => $id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->employeeRepository->destroy($id);
        $this->relationshipRepository->destroy('employees_has_companies', [
            'employeeId' => $id
        ]);

        $this->createLog('Funcion&aacute;rio', 'DELETE', ['id' => $id]);

        return redirect()->route('employee.index');
    }

    /**
     * @param int $id
     * @param array $companies
     */
    private function createRelationshipByCompany($id, $companies)
    {
        $this->relationshipRepository->destroy('employees_has_companies', ['employeeId' => $id]);
        foreach ($companies as $key => $value) {
            $this->relationshipRepository->create('employees_has_companies', [
                'employeeId' => $id,
                'companyId' => $value
            ]);
        }
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        if (\Session::has('company')) {
            $company = \Session::get('company');
            $data = [
                'Clientes' => route('company.index'),
                $company->fantasyName => route('company.show', $company->id)
            ];
        }

        if (\Session::has('provider')) {
            $provider = \Session::get('provider');
            $data['Prestadores de servi&ccedil;os'] = route('provider.index');
            $data[$provider->fantasyName] = route('provider.show', $provider->id);
        }

        $data['Funcion&aacute;rios'] = route('employee.index');
        $data[$location] = null;

        return $this->breadcrumbService->push($data)->get();
    }
}
