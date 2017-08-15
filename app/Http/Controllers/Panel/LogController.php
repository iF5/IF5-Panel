<?php

namespace App\Http\Controllers\Panel;

use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\LogRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Services\BreadcrumbService;
use App\Http\Controllers\Controller;

class LogController extends Controller
{

    /**
     * @var LogRepository
     */
    private $logRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    private $verbs = [
        'ALL' => 'Todos',
        'GET' => 'Visualizou',
        'POST' => 'Cadastrou',
        'PUT' => 'Atualizou',
        'DELETE' => 'Apagou'
    ];

    public function __construct(
        LogRepository $logRepository,
        CompanyRepository $companyRepository,
        ProviderRepository $providerRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->logRepository = $logRepository;
        $this->companyRepository = $companyRepository;
        $this->providerRepository = $providerRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dateInput = \Request::input('date');
        $searchData = [
            'date' => ($dateInput || !empty($dateInput)) ? $dateInput : (new \DateTime())->format('d/m/Y'),
            'verb' => (\Request::input('verb')) ? \Request::input('verb') : 'ALL'
        ];

        $date = implode('-', array_reverse(explode('/', $searchData['date'])));
        $method = ($searchData['verb'] === 'ALL') ? null : $searchData['verb'];
        $logs = $this->logRepository->findByToday($date, $method);

        return view('panel.log.list', [
            'logs' => $logs,
            'searchData' => $searchData,
            'verbs' => $this->verbs,
            'breadcrumbs' => $this->getBreadcrumb()
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
        $log = $this->logRepository->findById($id);

        return view('panel.log.show', [
            'log' => $this->formatting($log),
            'verbs' => $this->verbs,
            'breadcrumbs' => $this->getBreadcrumb('Visualizar')
        ]);
    }

    /**
     * @param $log
     * @return mixed
     */
    private function formatting($log)
    {
        if($log->role === 'provider'){
            $provider = $this->providerRepository->findById($log->providerId);
            $log->providerName = $provider->name;
        }

        if($log->role === 'company'){
            $company = $this->companyRepository->findById($log->companyId);
            $log->companyName = $company->name;
        }

        $log->data = json_decode($log->data, true);
        return $log;
    }

    /**
     * @param null $location
     * @return object
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            'Logs' => route('log.index'),
            $location => null
        ])->get();
    }

    public function test()
    {
        return view('panel.log.test');
    }

    public function test2()
    {
        return view('panel.log.test2');
    }

}
