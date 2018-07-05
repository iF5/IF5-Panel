<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogTrait;
use App\Models\Document;
use App\Repositories\Panel\DashboardRepository;
use App\Services\BreadcrumbService;
use App\Http\Traits\AuthTrait;
use App\Models\Company;

class DashboardController extends Controller
{

    use LogTrait;
    use AuthTrait;

    /**
     * @var DashboardRepository
     */
    protected $dashboardRepository;

    /**
     * @var BreadcrumbService
     */
    protected $breadcrumbService;

    private $companies;

    private $providers;

    private $documentCompanies;

    private $documentCompany;

    private $documentProviders;

    private $documentEmployees;

    const PENDING_UPLOAD = 0;

    const PENDING_APPROVAL = 1;

    const APPROVED = 2;

    const DISAPPROVED = 3;

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

        return view('panel.dashboard.index', $this->{$this->getRole()}());

        //$keyword = \Request::input('keyword');
        //$providers = $this->prepareReportToProviders($keyword);

        /*return view('panel.dashboard.index', [
            'documents' => $providers['documents'],
            'providers' => $providers['providers'],
            'breadcrumbs' => $this->getBreadcrumb(),
            'keyword' => $keyword
        ]);*/
    }

    private function admin()
    {
        $this->companies = $this->getCompanies();
        $this->documentCompanies = $this->getDocumentCompanies();
        $this->providers = $this->getProviders();
        $this->documentProviders = $this->getDocumentProviders();
        $this->documentEmployees = $this->getDocumentEmployees();

        return [
            'role' => $this->getRole(),
            'breadcrumbs' => $this->getBreadcrumb(),
            'companies' => $this->companies,
            'providers' => $this->providers,
            'documentCompanies' => $this->documentCompanies,
            'documentProviders' => $this->documentProviders,
            'documentEmployees' => $this->documentEmployees,
            'PENDING_UPLOAD' => self::PENDING_UPLOAD,
            'PENDING_APPROVAL' => self::PENDING_APPROVAL,
            'APPROVED' => self::APPROVED,
            'DISAPPROVED' => self::DISAPPROVED
        ];
    }

    private function company()
    {
        $company = $this->dashboardRepository->getCompanyById($this->getCompanyId());
        $providers = $this->dashboardRepository->getProviders($this->getCompanyId());
        $documentsCompany = $this->dashboardRepository->getDocumentCompanies($this->getCompanyId());
        $documentsProviders = $this->dashboardRepository->getDocumentProviders('companyId', $this->getCompanyId());
        $documentsEmployees = $this->dashboardRepository->getDocumentEmployees('companyId', $this->getCompanyId());

        return [
            'role' => $this->getRole(),
            'breadcrumbs' => $this->getBreadcrumb(),
            'company' => $company,
            'providers' => $providers->toArray(),
            'documentsCompany' => $documentsCompany->toArray(),
            'documentProviders' => $documentsProviders->toArray(),
            'documentEmployees' => $documentsEmployees->toArray(),
            'PENDING_UPLOAD' => self::PENDING_UPLOAD,
            'PENDING_APPROVAL' => self::PENDING_APPROVAL,
            'APPROVED' => self::APPROVED,
            'DISAPPROVED' => self::DISAPPROVED
        ];
    }

    private function provider()
    {
        $provider = $this->dashboardRepository->getProviderById($this->getProviderId());
        $documentsProviders = $this->dashboardRepository->getDocumentProviders('providerId', $this->getProviderId());
        $documentsEmployees = $this->dashboardRepository->getDocumentEmployees('providerId', $this->getProviderId());

        return [
            'role' => $this->getRole(),
            'breadcrumbs' => $this->getBreadcrumb(),
            'provider' => $provider->toArray(),
            'documentProviders' => $documentsProviders->toArray(),
            'documentEmployees' => $documentsEmployees->toArray(),
            'PENDING_UPLOAD' => self::PENDING_UPLOAD,
            'PENDING_APPROVAL' => self::PENDING_APPROVAL,
            'APPROVED' => self::APPROVED,
            'DISAPPROVED' => self::DISAPPROVED
        ];
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

    private function getProviders()
    {
        $newProviders = [];
        $providers = $this->dashboardRepository->getProviders();
        foreach($providers as $provider) {
            $newProviders[$provider->id]['name'] = $provider->name;
        }
        return $newProviders;
    }

    private function getDocumentCompanies()
    {
      $newDocumentCompanies = [];
      $documentCompanies = $this->dashboardRepository->getDocumentCompanies();
      return $this->formatData($documentCompanies);
    }

    private function getDocumentProviders()
    {
        $newDocumentProviders = [];
        $documentProviders = $this->dashboardRepository->getDocumentProviders();
        return $this->formatData($documentProviders);
    }

    private function getDocumentEmployees()
    {
        $documentEmployees = $this->dashboardRepository->getDocumentEmployees();
        return $this->formatData($documentEmployees);
    }

    private function formatData($Array)
    {
      $newArray = [];
      foreach ($Array as $array) {
          $companyId = $array->companyId;
          $status = $array->status;
          /**
           * $status = 0; Nenhum doc feito upload
           * $status = 1; Pendente aprovação
           * $status = 2; Aprovado
           * $status = 3; Reprovado
           */
          $status = !is_null($status) ? $status : 0;
          $newArray[$companyId][$status][] = $array->documentId;
      }
      return $newArray;
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
