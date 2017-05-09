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
            $this->reportRepository->findLike($this->getCompanyId(), $referenceDate) :
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