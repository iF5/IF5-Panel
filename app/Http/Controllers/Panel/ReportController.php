<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Traits\AuthTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Services\BreadcrumbService;
use App\Repositories\Panel\ReportRepository;


class ReportController
{

    use AuthTrait;

    /**
     * @var ReportRepository
     */
    private $reportRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    public function __construct(
        ReportRepository $reportRepository,
        CompanyRepository $companyRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->reportRepository = $reportRepository;
        $this->companyRepository = $companyRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('company', $this->companyRepository->findById($id));
        return redirect()->route('report.index');
    }

    /**
     * @return mixed
     */
    protected function getCompanyId()
    {
        return (\Session::has('company')) ? \Session::get('company')->id : \Auth::user()->companyId;
    }

    public function index()
    {
        $referenceDate = \Request::input('reference-date');
        $reports = ($referenceDate) ?
            $this->reportRepository->findByReferenceDate($this->getCompanyId(), $referenceDate) :
            $this->reportRepository->findOrderBy($this->getCompanyId());

        return view('panel.report.list', [
            'referenceDate' => $referenceDate,
            'reports' => $reports,
            'breadcrumbs' => $this->getBreadcrumb()
        ]);
    }


    public function upload(Request $request)
    {
        $dir = public_path() . '/uploads/';
        $files = $request->file('file');

        foreach ($files as $file) {
            $file->move($dir, $file->getClientOriginalName());
        }

        return response()->json([
            'message' => 'Os Arquivos foram enviados com sucesso!'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.report.form', [
            'report' => $this->reportRepository,
            'method' => 'POST',
            'route' => 'report.store',
            'parameters' => [],
            'breadcrumbs' => $this->getBreadcrumb('Cadastrar')
        ]);
    }

    protected function formRequest($data, $action = null)
    {
        if ($action === 'store') {
            $data['createdAt'] = (new \DateTime())->format('Y-m-d H:i:s');
            $data['companyId'] = $this->getCompanyId();
        }
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
        $this->validate(
            $request, $this->reportRepository->validateRules(), $this->reportRepository->validateMessages()
        );

        $data = $this->formRequest($request->all(), 'store');
        $this->reportRepository->create($data);

        return redirect()->route('report.create')->with([
            'success' => true,
            'message' => 'Relat&oacute;rio cadastrado com sucesso!'
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
        return view('panel.report.form', [
            'report' => $this->reportRepository->findOrFail($id),
            'route' => 'report.update',
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
            $request, $this->reportRepository->validateRules(), $this->reportRepository->validateMessages()
        );

        $data = $this->formRequest($request->all());
        $this->reportRepository->findOrFail($id)->update($data);

        return redirect()->route('report.edit', $id)->with([
            'success' => true,
            'message' => 'Relat&oacute;rio atualizado com sucesso!'
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
        $this->reportRepository->destroy($id);
        return redirect()->route('report.index');
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
                $company->name => route('company.show', $company->id)
            ];
        }

        $data['Relat&oacute;rios'] = route('report.index');
        $data[$location] = null;
        return $this->breadcrumbService->push($data)->get();
    }

}