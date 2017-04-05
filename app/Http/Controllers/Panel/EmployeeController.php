<?php

namespace App\Http\Controllers\Panel;

use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\RelationshipRepository;
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

    public function __construct(
        EmployeeRepository $employeeRepository,
        RelationshipRepository $relationshipRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->relationshipRepository = $relationshipRepository;
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
        $keyword = \Request::input('keyword');
        $employees = ($keyword)
            ? $this->employeeRepository->findLike($this->getProviderId(), 'name', $keyword)
            : $this->employeeRepository->findOrderBy($this->getProviderId());

        //dd($employees);

        return view('panel.employee.list', compact('keyword', 'employees'));
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
            'parameters' => []
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
        return view('panel.employee.show', compact('employee'));
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
            'parameters' => [$id]
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
}
