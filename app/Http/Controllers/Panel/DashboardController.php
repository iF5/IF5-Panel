<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Repositories\Panel\DashboardRepository;

class DashboardController extends Controller
{

    /**
     * @var DashboardRepository
     */
    protected $dashboardRepository;


    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }


    public function index()
    {
        $documents = Document::all();
        $providers = $this->prepareReportToProviders($documents);

        return view('panel.dashboard.index', [
            'documents' => $documents,
            'providers' => $providers
        ]);
    }

    /**
     * @param $documents
     * @return array
     */
    private function prepareReportToProviders($documents)
    {
        $providers = [];
        $data = $this->dashboardRepository->findDocumentAndEmployeeByProviders();

        foreach ($data as $d) {
            $providers[$d->providerId] = [
                'name' => $d->providerName,
                'employeeQuantity' => $d->employeeQuantity,
                'documents' => []
            ];
        }

        $totalDocuments = count($documents);
        $totalProviders = count($providers);
        for ($i = 1; $i <= $totalProviders; $i++) {
            for ($j = 1; $j <= $totalDocuments; $j++) {
                $providers[$i]['documents'][$j] = 0;
            }
        }

        foreach ($data as $j) {
            $providers[$j->providerId]['documents'][$j->documentId] = $j->documentQuantity;
        }
        return $providers;
    }

    public function employee()
    {
        return view('panel.dashboard.employee');
    }

}