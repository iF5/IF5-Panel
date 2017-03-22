<?php

namespace App\Http\Controllers\Panel;

use App\Repositories\Panel\RelationshipRepository;
use App\Repositories\Panel\CompanyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    public function __construct(
        CompanyRepository $companyRepository,
        RelationshipRepository $relationshipRepository
    )
    {
        $this->companyRepository = $companyRepository;
        $this->relationshipRepository = $relationshipRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $companies = ($keyword) ?
            $this->companyRepository->findLike('name', $keyword) :
            $this->companyRepository->findOrderBy();

        return view('panel.company.list', compact('keyword', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.company.form', [
            'company' => $this->companyRepository,
            'route' => 'company.store',
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
            $request, $this->companyRepository->validateRules(), $this->companyRepository->validateMessages()
        );

        $company = $this->companyRepository->create($request->all());

        return redirect()->route('company.create')->with([
            'success' => true,
            'message' => 'Empresa cadastrada com sucesso!',
            'route' => 'company.show',
            'id' => $company->id
        ]);
    }

    /**
     * @param int $id
     * @return int
     */
    /*private function checkId($id)
    {
        return (\Auth::user()->role === 'admin') ? $id : \Auth::user()->companyId;
    }
    */

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = $this->companyRepository->find($id);
        return view('panel.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = $this->companyRepository->findOrFail($id);

        return view('panel.company.form', [
            'company' => $company,
            'route' => 'company.update',
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
            $request, $this->companyRepository->validateRules($id), $this->companyRepository->validateMessages()
        );

        $this->companyRepository->findOrFail($id)->update($request->all());

        return redirect()->route('company.edit', $id)->with([
            'success' => true,
            'message' => 'Empresa atualizada com sucesso!',
            'route' => 'company.show',
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
        $this->companyRepository->destroy($id);
        $this->relationshipRepository->destroy('companies_has_providers', [
            'companyId' => $id
        ]);
        return redirect()->route('company.index');
    }

}
