<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\LogTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Repositories\Panel\ProviderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BreadcrumbService;
use App\Http\Traits\AuthTrait;

class ProviderController extends Controller
{
    use AuthTrait, LogTrait;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

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

    public function __construct(
        ProviderRepository $providerRepository,
        CompanyRepository $companyRepository,
        DocumentRepository $documentRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->providerRepository = $providerRepository;
        $this->companyRepository = $companyRepository;
        $this->documentRepository = $documentRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
        $this->states = \Config::get('states');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('company', $this->companyRepository->findById($id));
        return redirect()->route('provider.index');
    }

    /**
     * @return mixed
     */
    protected function getCompanyId()
    {
        return (\Session::has('company')) ? \Session::get('company')->id : \Auth::user()->companyId;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Prestadores de servi&ccedil;os';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $providers = ($keyword) ?
            $this->providerRepository->findLike($this->getCompanyId(), 'name', $keyword) :
            $this->providerRepository->findOrderBy($this->getCompanyId());

        return view('panel.provider.list', [
            'keyword' => $keyword,
            'providers' => $providers,
            'breadcrumbs' => $this->getBreadcrumb()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function associate(Request $request)
    {
        $search = false;
        $cnpj = null;
        $provider = null;
        $success = false;

        if ($request->isMethod('post') && $request->get('action') === 'search') {
            $search = true;
            $cnpj = $request->get('cnpj');
            $provider = $this->providerRepository->findByCnpj($cnpj);
            \Session::put('cnpj', $cnpj);
        }

        if ($request->isMethod('post') && $request->get('action') === 'associate') {
            $data = [
                'companyId' => $this->getCompanyId(),
                'providerId' => $request->get('providerId'),
                'status' => $this->isAdmin()
            ];

            $this->relationshipRepository->create('companies_has_providers', $data);
            $success = true;
            \Session::remove('cnpj');
            $this->createLog('POST', $data);
        }

        $breadcrumbs = $this->getBreadcrumb('Cadastrar/Incluir');
        return view('panel.provider.form-associate', compact('search', 'cnpj', 'provider', 'success', 'breadcrumbs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function formRequest(\Illuminate\Http\Request $request)
    {
        $data = $request->all();
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $data['companyId'] = $this->getCompanyId();
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
        if (!\Session::has('cnpj')) {
            return redirect()->route('provider.associate');
        }

        $this->providerRepository->cnpj = \Session::get('cnpj');
        $this->providerRepository->cnpjHidden = true;

        return view('panel.provider.form', [
            'provider' => $this->providerRepository,
            'documents' => $this->documentRepository->findAllByEntity(2),
            'selectedDocuments' => [],
            'states' => $this->states,
            'method' => 'POST',
            'route' => 'provider.store',
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
            $request, $this->providerRepository->rules(), $this->providerRepository->messages()
        );

        $data = $this->formRequest($request);
        $provider = $this->providerRepository->create($data);
        $this->relationshipRepository->create('companies_has_providers', [
            'companyId' => $this->getCompanyId(),
            'providerId' => $provider->id,
            'status' => $this->isAdmin()
        ]);

        $this->createLog('POST', $data);
        \Session::remove('cnpj');

        return redirect()
            ->route('provider.associate')
            ->with([
                'success' => true,
                'message' => 'Prestador de servi&ccedil;o cadastrado com sucesso!'
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
        $provider = $this->providerRepository->findByCompany($id, $this->getCompanyId());

        return view('panel.provider.show', [
            'provider' => $provider,
            'documents' => $this->documentRepository->findAllByEntity(2),
            'selectedDocuments' => json_decode($provider->documents, true),
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
        $provider = $this->providerRepository->findOrFail($id);
        $provider->cnpjHidden = ($this->isAdmin() || $this->isProvider()) ? false : true;

        return view('panel.provider.form', [
            'provider' => $provider,
            'documents' => $this->documentRepository->findAllByEntity(2),
            'selectedDocuments' => json_decode($provider->documents, true),
            'states' => $this->states,
            'route' => 'provider.update',
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
            $request, $this->providerRepository->rules(), $this->providerRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->providerRepository->findOrFail($id)->update($data);
        $this->createLog('PUT', $data);

        return redirect()->route('provider.edit', $id)->with([
            'success' => true,
            'message' => 'Prestador de servi&ccedil;o atualizado com sucesso!'
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
        $data = [
            'companyId' => $this->getCompanyId(),
            'providerId' => $id
        ];
        $this->relationshipRepository->destroy('companies_has_providers', $data);
        $this->createLog('DELETE', $data);
        return redirect()->route('provider.index');
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

        $data['Prestadores de servi&ccedil;os'] = route('provider.index');
        $data[$location] = null;
        return $this->breadcrumbService->push($data)->get();
    }

}
