<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

use App\Repositories\Panel\ProviderRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;

class PendencyController extends Controller
{

    private $providerRepository;

    private $breadcrumbService;

    public function __construct(
        ProviderRepository $providerRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->providerRepository = $providerRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * Display a listing of the resource.
     */
    public function provider()
    {
        $providers = $this->providerRepository->findByPendency();

        return view('panel.pendency.list', [
            'keyword' => null,
            'providers' => $providers,
            'breadcrumbs' => $this->getBreadcrumb('Prestadores de servi&ccedil;os')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService
            ->add('Pend&ecirc;ncias', route('pendency.provider'))
            ->add($location, null, true)
            ->get();
    }
}
