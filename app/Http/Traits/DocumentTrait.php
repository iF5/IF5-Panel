<?php

namespace App\Http\Traits;

use App\Repositories\Panel\DocumentRepository;
use Illuminate\Http\Request;

trait DocumentTrait
{
    use LogTrait;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @param null $action
     * @return null
     */
    public function getRoute($action = null)
    {
        return null;
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return 0;
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $documents = ($keyword) ?
            $this->documentRepository->findLike('name', $keyword) :
            $this->documentRepository->findOrderBy();

        return view('panel.document.list', [
            'keyword' => $keyword,
            'route' => $this->getRoute('create'),
            'documents' => $documents,
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
        $data['entityGroup'] = $this->getEntityGroup();

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
        return view('panel.document.form', [
            'documents' => $this->documentRepository,
            'route' => $this->getRoute('store'),
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
            $request, $this->documentRepository->rules(), $this->documentRepository->messages()
        );

        $data = $this->formRequest($request);
        $document = $this->documentRepository->create($data);
        $this->createLog('POST', $data);

        return redirect()->route($this->getRoute('create'))->with([
            'success' => true,
            'message' => 'Documento cadastrado com sucesso!',
            'route' => 'document.show',
            'id' => $document->id
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
        return view('panel.document.show', [
            'document' => $this->documentRepository->findOrFail($id),
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
        return view('panel.document.form', [
            'documentType' => $this->documentRepository->findOrFail($id),
            'route' => $this->getRoute('update'),
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
            $request, $this->documentRepository->rules(), $this->documentRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->documentRepository->findOrFail($id)->update($data);
        $this->createLog('PUT', $data);

        return redirect()->route('document-types.edit', $id)->with([
            'success' => true,
            'message' => 'Documento atualizado com sucesso!',
            'route' => $this->getRoute('show'),
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
        $this->documentRepository->destroy($id);
        $this->createLog('DELETE', ['id' => $id]);
        return redirect()->route($this->getRoute('index'));
    }

}