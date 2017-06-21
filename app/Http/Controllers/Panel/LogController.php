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

    private $verbs = [
        'GET' => 'Visualizou',
        'POST' => 'Cadastrou',
        'PUT' => 'Atualizou',
        'DELETE' => 'Apagou'
    ];

    public function __construct(
        LogRepository $logRepository,
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

        if (!$date) {
            $date = (new \DateTime())->format('Y-m-d');
        }

        $logs = $this->logRepository->findByToday($date);

        return view('panel.log.list', [
            'logs' => $logs,
            'keyword' => null,
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
        $log->data = json_decode($log->data, true);

        return view('panel.log.show', [
            'log' => $log,
            'verbs' => $this->verbs,
            'breadcrumbs' => $this->getBreadcrumb('Visualizar')
        ]);
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

}
