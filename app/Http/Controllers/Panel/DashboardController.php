<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogTrait;
use App\Models\Document;
use App\Repositories\Panel\DashboardRepository;
use App\Services\BreadcrumbService;

class DashboardController extends Controller
{

    use LogTrait;

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
        $this->getCompanies();
        $this->getDocumentCompanies();

        return view('panel.dashboard.index', [

            'breadcrumbs' => $this->getBreadcrumb()

        ]);

        //$keyword = \Request::input('keyword');
        //$providers = $this->prepareReportToProviders($keyword);

        /*return view('panel.dashboard.index', [
            'documents' => $providers['documents'],
            'providers' => $providers['providers'],
            'breadcrumbs' => $this->getBreadcrumb(),
            'keyword' => $keyword
        ]);*/
    }

    private function getCompanies()
    {
        $newCompanies = [];
        $companies = $this->dashboardRepository->getCompanies();
        foreach($companies as $company) {
            $newCompanies[$company->id]['name'] = $company->name;
        }
        return $newCompanies;
    }

    private function getDocumentCompanies()
    {
      $newDocumentCompanies = [];
      $documentCompanies = $this->dashboardRepository->getDocumentCompanies();
      foreach ($documentCompanies as $documentCompany) {
          $companyId = $documentCompany->companyId;
          $status = $documentCompany->status;
          
          !is_null($status) ? $status : 0;
          $newDocumentCompanies[$companyId][$status][] = $documentCompany->documentId;
      }
      dd($newDocumentCompanies);
      //dd($documentCompanies);
    }


    #--------------------------------------------------------------------------#

    /**
     * @param int $totalDocuments
     * @param string $keyword
     * @return array
     */
    private function prepareReportToProviders($keyword = null)
    {
        $employeeHasDocuments = $this->dashboardRepository->emploweeHasDocuments();
        $employeesByProviders = $this->dashboardRepository->employeesByProviders($keyword);

        $providerHasDocuments = [];
        foreach($employeeHasDocuments as $hasDocument){
            $providerHasDocuments["provider-" . $hasDocument->providerId] = [
                'documentId' => $hasDocument->documentId,
                'documentQuantity' => $hasDocument->documentQuantity
            ];
        }



        $providerEmployeeQtd = [];
        foreach($employeesByProviders as $byProvider){
            $providerEmployeeQtd["provider-" . $byProvider->providerId] = [
                'providerId' =>  $byProvider->providerId,
                'providerName' => $byProvider->providerName,
                'employeeQuantity' => $byProvider->employeeQuantity
            ];
        }

        $merge = array_merge_recursive($providerHasDocuments, $providerEmployeeQtd);

        $dash = [];
        $documents = Document::all();
        foreach($documents as $doc){
            foreach($merge as $key => $mer){
                if(!array_key_exists('documentId', $mer)) {
                    $mer['documentId'] = 0;
                }
                $dash[$doc->name][$key]["documentQuantity"] = 0;
                $dash[$doc->name][$key]["employeeQuantity"] = 0;
                if($mer['documentId'] == $doc->id){
                    $dash[$doc->name][$key]["documentQuantity"] = $mer['documentQuantity'];
                    $dash[$doc->name][$key]["employeeQuantity"] = $mer['employeeQuantity'];
                }

            }
        }

        $providers['documents'] = $dash;
        $providers['providers'] = $merge;

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
            'documents' => $employees['documents'],
            'employees' => $employees['employees'],
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
        $dash = [];
        $employeeData = $this->dashboardRepository->findEmployeesByProviderIdNew($providerId);

        $documents = Document::all();
        foreach($documents as $doc){
            foreach($employeeData as $key => $employee){
                $dash[$doc->name][$key]["documentQuantity"] = 0;
                if($employee->documentId == $doc->id){
                    $dash[$doc->name][$key]["documentQuantity"] = $employee->documentQuantity;
                }
            }
        }

        $employees['documents'] = $dash;
        $employees['employees'] = $employeeData;

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
