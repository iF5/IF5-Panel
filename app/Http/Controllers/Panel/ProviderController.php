<?php

namespace App\Http\Controllers\Panel;

use App\Repositories\Panel\RelationshipRepository;
use App\Repositories\Panel\ProviderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        RelationshipRepository $relationshipRepository
    )
    {
        $this->providerRepository = $providerRepository;
        $this->relationshipRepository = $relationshipRepository;
    }

    public function identify($companyId)
    {
        \Session::put('companyId', $companyId);
        return redirect()->route('provider.index');
    }

    protected function getCompanyId()
    {
        return (\Auth::user()->role === 'admin') ? \Session::get('companyId') : \Auth::user()->companyId;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isCompany');

        $keyword = \Request::input('keyword');
        $providers = ($keyword) ?
            $this->providerRepository->findLikeByCompany('name', $keyword, $this->getCompanyId()) :
            $this->providerRepository->findByCompany($this->getCompanyId());

        return view('panel.provider.list', [
            'keyword' => $keyword,
            'providers' => $providers
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
            $this->relationshipRepository->create('companies_has_providers', [
                'companyId' => $this->getCompanyId(),
                'providerId' => $request->get('providerId')
            ]);
            $success = true;
            \Session::remove('cnpj');
        }

        return view('panel.provider.form-associate', compact('search', 'cnpj', 'provider', 'success'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isCompany');

        if (!\Session::has('cnpj')) {
            return redirect()->route('provider.associate');
        }

        return view('panel.provider.form', [
            'provider' => (object)[
                'cnpj' => \Session::get('cnpj'),
                'cnpjHidden' => true
            ],
            'method' => 'POST',
            'route' => 'provider.store',
            'parameters' => []
        ]);
    }

    protected function formRequest($data)
    {
        $data['companyId'] = $this->getCompanyId();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isCompany');

        $this->validate(
            $request, $this->providerRepository->validateRules(), $this->providerRepository->validateMessages()
        );

        $data = $this->formRequest($request->all());
        $provider = $this->providerRepository->create($data);
        $this->relationshipRepository->create('companies_has_providers', [
            'companyId' => $this->getCompanyId(),
            'providerId' => $provider->id
        ]);

        \Session::remove('cnpj');
        return redirect()
            ->route('provider.associate')
            ->with([
                'success' => true,
                'message' => 'Prestador de servi&ccedil;os cadastrado com sucesso!'
            ]);
    }

    /**
     * @param int $id
     * @return int
     */
    private function checkId($id)
    {
        return (in_array(\Auth::user()->role, ['admin', 'company'])) ? $id : \Auth::user()->providerId;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provider = $this->providerRepository->find($id);
        return view('panel.provider.show', compact('provider'));
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
        $route = 'provider.update';
        $method = 'PUT';
        $parameters = [$id];
        return view('panel.provider.form', compact('provider', 'method', 'route', 'parameters'));
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
        //$id = $this->checkId($id);

        $this->validate(
            $request, $this->providerRepository->validateRules(), $this->providerRepository->validateMessages()
        );

        $data = $this->formRequest($request->all());
        $this->providerRepository
            ->findOrFail($id)
            ->update($data);

        return redirect()->route('provider.edit', $id)->with([
            'success' => true,
            'message' => 'Prestador de servi&ccedil;os atualizado com sucesso!'
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
        $this->authorize('isCompany');
        $this->relationshipRepository->destroy('companies_has_providers', [
            'companyId' => $this->getCompanyId(),
            'providerId' => $id
        ]);
        return redirect()->route('provider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**public function delete($id)
     * {
     * $this->authorize('isAdmin');
     * $this->providerRepository->destroy($id);
     * return redirect()->route('provider.index');
     * }
     */
}
