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

        return view('panel.employee.list', compact('keyword', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.employee.form', [
            'employee' => (object)[
                'providerId' => $this->getProviderId()
            ],
            'companies' => (object)[
                1 => 'Locaweb',
                2 => 'Unimed',
                3 => 'Allin',
                4 => 'Tray'
            ],
            'hasCompanies' => [2, 4],
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

        $employee = $this->employeeRepository->create($request->all());

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

        return view('panel.employee.form', [
            'employee' => $employee,
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

        $this->employeeRepository->findOrFail($id)->update($request->all());

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
        /*
         $this->relationshipRepository->destroy('employees_has_companies', [
            'employeeId' => $id,
            'companyId' => $companyId
        ]);
        */
        return redirect()->route('employee.index');
    }
}
