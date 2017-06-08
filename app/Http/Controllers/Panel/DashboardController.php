<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Repositories\Panel\DashboardRepository;
use App\Services\BreadcrumbService;

class DashboardController extends Controller
{

    /**
     * @var DashboardRepository
     */
    protected $dashboardRepository;

    /**
     * @var BreadcrumbService
     */
    protected $breadcrumbService;


    public function __construct(
        DashboardRepository $dashboardRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $documents = Document::all();
        $totalDocuments = count($documents);
        $providers = $this->prepareReportToProviders($totalDocuments, $keyword);

        return view('panel.dashboard.index', [
            'documents' => $documents,
            'providers' => $providers,
            'breadcrumbs' => $this->getBreadcrumb(),
            'keyword' => $keyword,
            'totalDocuments' => $totalDocuments
        ]);
    }

    /**
     * @param int $totalDocuments
     * @param string $keyword
     * @return array
     */
    private function prepareReportToProviders($totalDocuments, $keyword = null)
    {
        $providers = [];
        $data = $this->dashboardRepository->findProviders($keyword);

        foreach ($data as $d) {
            $providers[$d->providerId] = [
                'id' => $d->providerId,
                'name' => $d->providerName,
                'employeeQuantity' => $d->employeeQuantity,
                'documents' => []
            ];
        }

        foreach ($providers as &$provider) {
            for ($i = 1; $i <= $totalDocuments; $i++) {
                $provider['documents'][$i] = 0;
            }
        }

        foreach ($data as $d) {
            $providers[$d->providerId]['documents'][$d->documentId] = $d->documentQuantity;
        }

        return $providers;
    }

    /**
     * @param $providerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employee($providerId)
    {
        $documents = Document::all();
        $totalDocuments = count($documents);
        $employees = $this->prepareReportToEmployee($totalDocuments, $providerId);

        return view('panel.dashboard.employee', [
            'documents' => $documents,
            'employees' => $employees,
            'breadcrumbs' => $this->getBreadcrumb('Funcion&aacute;rios'),
            'totalDocuments' => $totalDocuments
        ]);
    }

    /**
     * @param int $totalDocuments
     * @param int $providerId
     * @return array
     */
    private function prepareReportToEmployee($totalDocuments, $providerId)
    {
        $employees = [];
        $data = $this->dashboardRepository->findEmployeesByProviderId($providerId);

        foreach ($data as $d) {
            $employees[$d->employeeId] = [
                'id' => $d->employeeId,
                'name' => $d->employeeName,
                'documents' => []
            ];
        }

        foreach ($employees as &$employee) {
            for ($i = 1; $i <= $totalDocuments; $i++) {
                $employee['documents'][$i] = 0;
            }
        }

        foreach ($data as $d) {
            $employees[$d->employeeId]['documents'][$d->documentId] = $d->documentQuantity;
        }

        return $employees;
    }


    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        $data['Dashboard'] = route('dashboard.index');
        $data[$location] = null;

        return $this->breadcrumbService->push($data)->get();
    }

}