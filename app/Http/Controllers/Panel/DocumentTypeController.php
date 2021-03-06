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
     * @param Request $request
     * @return mixed
     */
    protected function formRequest(Request $request)
    {
        $data = $request->all();
        $now = (new \DateTime())->format('Y-m-d H:i:s');
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
            $request, $this->documentTypeRepository->rules(), $this->documentTypeRepository->messages()
        );

        $data = $this->formRequest($request);
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
        return view('panel.document-types.show', [
            'documentType' => $this->documentTypeRepository->findOrFail($id),
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
        return view('panel.document-types.form', [
            'documentType' => $this->documentTypeRepository->findOrFail($id),
            'route' => 'document-types.update',
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
            $request, $this->documentTypeRepository->rules(), $this->documentTypeRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->documentTypeRepository->findOrFail($id)->update($data);
        $this->createLog('PUT', $data);

        return redirect()->route('document-types.edit', $id)->with([
            'success' => true,
            'message' => 'Tipo de documento atualizado com sucesso!',
            'route' => 'document-types.show',
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
        $this->documentTypeRepository->destroy($id);
        $this->createLog('DELETE', ['id' => $id]);
        return redirect()->route('document-types.index');
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
