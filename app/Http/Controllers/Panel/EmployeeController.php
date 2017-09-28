<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\AuthTrait;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\DocumentRepository;
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
     * @var ProviderRepository
     */
    private $providerRepository;

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

    /**
     * @var array
     */
    private $states;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepository $employeeRepository
     * @param ProviderRepository $providerRepository
     * @param DocumentRepository $documentRepository
     * @param RelationshipRepository $relationshipRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        EmployeeRepository $employeeRepository,
        ProviderRepository $providerRepository,
        DocumentRepository $documentRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->providerRepository = $providerRepository;
        $this->documentRepository = $documentRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
        $this->states = \Config::get('states');

    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Funcion&aacute;rios';
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function formRequest(\Illuminate\Http\Request $request)
    {
        $data = $request->all();
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $data['salaryCap'] = str_replace(['.', ','], ['', '.'], $data['salaryCap']);
        //$data['salaryCap'] = number_format($data['salaryCap'], 2, ',', '');
        $data['status'] = $this->isAdmin();
        $data['documents'] = json_encode($data['documents']);
        $data['updatedAt'] = $now;

        if (strtoupper($request->getMethod()) === 'POST') {
            $data['createdAt'] = $now;
        }

        return $data;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->employeeRepository->providerId = $this->getProviderId();
        $this->employeeRepository->hasChildren = 0;

        return view('panel.employee.form', [
            'employee' => $this->employeeRepository,
            'companies' => $this->getCompanies(),
            'documents' => $this->documentRepository->findAllByEntity(3),
            'selectedDocuments' => [],
            'states' => $this->states,
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
            $request, $this->employeeRepository->rules(), $this->employeeRepository->messages()
        );

        $data = $this->formRequest($request);
        $employee = $this->employeeRepository->create($data);
        $this->createRelationshipByCompany($employee->id, $data['companies']);
        $this->createLog('POST', $data);

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
            'documents' => $this->documentRepository->findAllByEntity(3),
            'selectedDocuments' => json_decode($employee->documents, true),
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

        return view('panel.employee.form', [
            'employee' => $employee,
            'companies' => $this->getCompanies($id),
            'documents' => $this->documentRepository->findAllByEntity(3),
            'selectedDocuments' => json_decode($employee->documents, true),
            'states' => $this->states,
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
            $request, $this->employeeRepository->rules($id), $this->employeeRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->employeeRepository->findOrFail($id)->update($data);
        $this->createRelationshipByCompany($id, $data['companies']);
        $this->createLog('PUT', $data);

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
        $this->createLog('DELETE', ['id' => $id]);

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
