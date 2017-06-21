<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\LogTrait;
use App\Repositories\Panel\LogRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
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

    public function __construct(
        LogRepository  $logRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->logRepository = $logRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = \Request::input('date');
        
        if(!$date){
            $date = (new \DateTime())->format('Y-m-d');
        }

        dd($this->logRepository->findByToday($date));

        return view('panel.company.list', [
            'companies' => $companies,
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
        $company = $this->companyRepository->find($id);

        return view('panel.company.show', [
            'company' => $company,
            'states' => $this->states,
            'breadcrumbs' => $this->getBreadcrumb('Visualizar')
        ]);
    }

}
