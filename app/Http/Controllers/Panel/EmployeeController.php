<?php

namespace App\Http\Controllers\Panel;

use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{

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
        EmployeeRepository $employeeRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;

    }

    /**
     * @param int $providerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($providerId)
    {
        \Session::put('providerId', $providerId);
        return redirect()->route('employee.index');
    }

    /**
     * @return int
     */
    protected function getProviderId()
    {
        return (in_array(\Auth::user()->role, ['admin', 'company']))
            ? \Session::get('providerId')
            : \Auth::user()->providerId;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->getBreadcrumb();

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = $this->employeeRepository->findAllByCompany($this->getProviderId());

        return view('panel.employee.form', [
            'employee' => (object)[
                'providerId' => $this->getProviderId()
            ],
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

        $data = $request->all();
        $employee = $this->employeeRepository->create($data);
        $this->createRelationshipByCompany($employee->id, $data['companies']);

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
        return view('panel.employee.show', [
            'employee' => $employee,
            'breadcrumbs' => $this->getBreadcrumb('Visualizar')
        ]);
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
        $companies = $this->employeeRepository->findAllByCompany($this->getProviderId());

        return view('panel.employee.form', [
            'employee' => $employee,
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

        $data = $request->all();
        $this->employeeRepository->findOrFail($id)->update($data);
        $this->createRelationshipByCompany($id, $data['companies']);

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
            $data['Clientes'] = route('company.index');
            $data[$company->name] = route('company.show', $company->id);
        }

        if (\Session::has('provider')) {
            $provider = \Session::get('provider');
            $data['Prestadores de servi&ccedil;os'] = route('provider.index');
            $data[$provider->name] = route('provider.show', $provider->id);
        }

        $data['Funcion&aacute;rios'] = route('employee.index');
        $data[$location] = null;

        return $this->breadcrumbService->push($data)->get();
    }
}
