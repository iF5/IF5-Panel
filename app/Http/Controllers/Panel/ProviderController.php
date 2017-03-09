<?php

namespace App\Http\Controllers\Panel;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    private $provider;

    private $totalPerPage = 2;

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function identify($companyId)
    {
        \Session::put('companyId', $companyId);
        return redirect()->route("provider.index");
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

        $providers = $this->provider
            ->where('companyId', '=', $this->getCompanyId())
            ->paginate($this->totalPerPage);

        return view('panel.provider.list', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isCompany');
        $provider = $this->provider;
        $route = 'provider.store';
        $method = 'POST';
        $parameters = [];
        return view('panel.provider.form', compact('provider', 'method', 'route', 'parameters'));
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

        $this->validate($request, $this->provider->validationRules());
        $data = $this->formRequest($request->all());
        $this->provider->create($data);

        return redirect()
            ->route('provider.create')
            ->with('success', 'Prestador cadastrado com sucesso!');
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
        //
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

        $provider = $this->provider->findOrFail($id);
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
        $id = $this->checkId($id);

        $this->validate($request, $this->provider->validationRules());
        $data = $this->formRequest($request->all());
        $this->provider
            ->findOrFail($id)
            ->update($data);

        return redirect()
            ->route('provider.edit', $id)
            ->with('success', 'Prestador atualizado com sucesso!');
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

        $this->provider->destroy($id);
        return redirect()->route('provider.index');
    }
}
