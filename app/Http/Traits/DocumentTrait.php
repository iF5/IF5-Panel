<?php

namespace App\Http\Traits;


trait DocumentTrait
{
    use LogTrait;

    /**
     * @var \App\Repositories\Panel\DocumentTypeRepository
     */
    private $documentTypeRepository;

    /**
     * @var \App\Repositories\Panel\DocumentRepository
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
     * @return mixed
     */
    protected function getPeriodicities()
    {
        return \Config::get('periodicities');
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
            $this->documentRepository->findLike($this->getEntityGroup(), 'name', $keyword) :
            $this->documentRepository->findOrderBy($this->getEntityGroup());

        return view('panel.document.list', [
            'keyword' => $keyword,
            'route' => $this->getRoute(),
            'periodicities' => $this->getPeriodicities(),
            'documents' => $documents,
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
        $document = $this->documentRepository;
        $document->periodicity = 1;
        return view('panel.document.form', [
            'document' => $document,
            'documentTypes' => $this->documentTypeRepository->all(),
            'periodicities' => $this->getPeriodicities(),
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
    public function store(\Illuminate\Http\Request $request)
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
            'route' => $this->getRoute('show'),
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
        $document = $this->documentRepository->findOrFail($id);
        return view('panel.document.show', [
            'document' => $document,
            'documentType' => $this->documentTypeRepository->find($document->documentTypeId),
            'periodicities' => $this->getPeriodicities(),
            'route' => $this->getRoute(),
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
            'document' => $this->documentRepository->findOrFail($id),
            'documentTypes' => $this->documentTypeRepository->all(),
            'periodicities' => $this->getPeriodicities(),
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
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $this->validate(
            $request, $this->documentRepository->rules(), $this->documentRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->documentRepository->findOrFail($id)->update($data);
        $this->createLog('PUT', $data);

        return redirect()->route($this->getRoute('edit'), $id)->with([
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