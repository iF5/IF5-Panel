<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\LogTrait;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Repositories\Panel\CompanyRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{

    use LogTrait;

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

    /**
     * @var array
     */
    private $states;

    /**
     * CompanyController constructor.
     * @param CompanyRepository $companyRepository
     * @param DocumentRepository $documentRepository
     * @param RelationshipRepository $relationshipRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        CompanyRepository $companyRepository,
        DocumentRepository $documentRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->companyRepository = $companyRepository;
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
        return 'Clientes';
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

        return view('panel.company.list', [
            'keyword' => $keyword,
            'companies' => $companies,
            'breadcrumbs' => $this->getBreadcrumb()
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
        $data['documents'] = json_encode($data['documents']);
        $data['updatedAt'] = $now;

        if (strtoupper($request->getMethod()) === 'POST') {
            $data['createdAt'] = $now;
        }

        return $data;
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
            'documents' => $this->documentRepository->findAllByEntity(1),
            'selectedDocuments' => [],
            'states' => $this->states,
            'route' => 'company.store',
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
            $request, $this->companyRepository->rules(), $this->companyRepository->messages()
        );

        $data = $this->formRequest($request);
        $company = $this->companyRepository->create($data);
        $this->createLog('POST', $data);

        return redirect()->route('company.create')->with([
            'success' => true,
            'message' => 'Cliente cadastrado com sucesso!',
            'route' => 'company.show',
            'id' => $company->id
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
        $company = $this->companyRepository->find($id);

        return view('panel.company.show', [
            'company' => $company,
            'documents' => $this->documentRepository->findAllByEntity(1),
            'selectedDocuments' => json_decode($company->documents, true),
            'states' => $this->states,
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
        $company = $this->companyRepository->findOrFail($id);

        return view('panel.company.form', [
            'company' => $company,
            'documents' => $this->documentRepository->findAllByEntity(1),
            'selectedDocuments' => json_decode($company->documents, true),
            'states' => $this->states,
            'route' => 'company.update',
            'method' => 'PUT',
            'parameters' => [$id],
            'breadcrumbs' => $this->getBreadcrumb('Editar')
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
            $request, $this->companyRepository->rules($id), $this->companyRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->companyRepository->findOrFail($id)->update($data);
        $this->createLog('PUT', $data);

        return redirect()->route('company.edit', $id)->with([
            'success' => true,
            'message' => 'Cliente atualizado com sucesso!',
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
        $this->createLog('DELETE', ['id' => $id]);

        return redirect()->route('company.index');
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
