<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\LogTrait;
use App\Repositories\Panel\DocumentTypeRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentTypeController extends Controller
{

    use LogTrait;

    /**
     * @var DocumentTypeRepository
     */
    private $documentTypeRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * DocumentTypeController constructor.
     * @param DocumentTypeRepository $documentTypeRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        DocumentTypeRepository $documentTypeRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->documentTypeRepository = $documentTypeRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Tipos de documentos';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $documentTypes = ($keyword) ?
            $this->documentTypeRepository->findLike('name', $keyword) :
            $this->documentTypeRepository->findOrderBy();

        return view('panel.document-types.list', [
            'keyword' => $keyword,
            'documentTypes' => $documentTypes,
            'breadcrumbs' => $this->getBreadcrumb()
        ]);
    }

    /**
     * @param array $data
     * @param string $action
     * @return mixed
     */
    protected function formRequest($data, $action = null)
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');

        $data['updatedAt'] = $now;
        if ($action === 'store') {
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
        return view('panel.document-types.form', [
            'company' => $this->documentTypeRepository,
            'route' => 'document-types.store',
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
            $request, $this->documentTypeRepository->validateRules(), $this->documentTypeRepository->validateMessages()
        );

        $data = $this->formRequest($request->all(), 'store');
        $documentType = $this->documentTypeRepository->create($data);
        $this->createLog('POST', $data);

        return redirect()->route('document-types.create')->with([
            'success' => true,
            'message' => 'Tipo de documento cadastrado com sucesso!',
            'route' => 'document-types.show',
            'id' => $documentType->id
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
            $request, $this->companyRepository->validateRules($id), $this->companyRepository->validateMessages()
        );

        $data = $this->formRequest($request->all());
        $this->companyRepository->findOrFail($id)->update($data);
        $this->createLog('Empresa', 'PUT', $data);

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
        $this->createLog('Empresa', 'DELETE', ['id' => $id]);

        return redirect()->route('company.index');
    }

    /**
     * @param null $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            'Tipos de documentos' => route('document-types.index'),
            $location => null
        ])->get();
    }

}
