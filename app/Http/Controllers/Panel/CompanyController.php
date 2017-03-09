<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    private $company;

    private $totalPerPage = 2;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('onlyAdmin');

        $companies = $this->company
            ->paginate($this->totalPerPage);

        return view('panel.company.list', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('onlyAdmin');

        $company = $this->company;
        $route = 'company.store';
        $method = 'POST';
        $parameters = [];
        return view('panel.company.form', compact('company', 'method', 'route', 'parameters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('onlyAdmin');

        $this->validate($request, $this->company->validationRules());
        $this->company->create($request->all());
        return redirect()
            ->route('company.create')
            ->with('success', 'Empresa cadastrada com sucesso!');
    }

    /**
     * @param int $id
     * @return int
     */
    private function checkId($id)
    {
        return (\Auth::user()->role === 'admin') ? $id : \Auth::user()->companyId;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        $id = $this->checkId($id);
        $company = $this->company->find($id);
        return view('panel.company.show', compact('company'));
        */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->checkId($id);

        $company = $this->company->findOrFail($id);
        $route = 'company.update';
        $method = 'PUT';
        $parameters = [$id];
        return view('panel.company.form', compact('company', 'method', 'route', 'parameters'));
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
        $id = $this->checkId($id);

        $this->validate($request, $this->company->validationRules());
        $this->company
            ->findOrFail($id)
            ->update($request->all());

        return redirect()
            ->route('company.edit', $id)
            ->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('onlyAdmin');

        $this->company->destroy($id);
        return redirect()->route('company.index');
    }

}
