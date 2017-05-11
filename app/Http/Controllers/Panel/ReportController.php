<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\AuthTrait;
use App\Repositories\Panel\CompanyRepository;
use App\Services\BreadcrumbService;
use App\Repositories\Panel\ReportRepository;


class ReportController extends Controller
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

    /**
     * @var array
     */
    private $extensions = ['pdf'];

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
        $report = $this->reportRepository->findById($id);
        $path = $this->getDirPath($report->companyId, $report->referenceDate);
        unlink($path . $report->fileName);
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

    /**
     * @param $companyId
     * @param $referenceDate
     * @return string
     */
    protected function getDirPath($companyId, $referenceDate)
    {
        $year = substr($referenceDate, 3, 4);
        $month = substr($referenceDate, 0, 2);
        return storage_path() . "/upload/report/{$companyId}/{$year}/{$month}/";
    }

    /**
     * @param $path
     */
    protected function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, $id)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $this->extensions)) {
            return response()->json([
                'message' => 'Só são permitidos arquivos do tipo ' . implode(', ', $this->extensions) . '.'
            ]);
        }

        $report = $this->reportRepository->findById($id);
        $dirPath = $this->getDirPath($report->companyId, $report->referenceDate);
        $this->createDir($dirPath);

        $fileOriginalName = $file->getClientOriginalName();
        $fileName = sprintf('%s.%s', sha1($report->id . $report->referenceDate), $extension);
        if (!$file->move($dirPath, $fileName)) {
            return response()->json([
                'message' => "Falha ao enviar o arquivo <b>{$fileOriginalName}</b> por favor tente novamente!"
            ]);
        }

        $this->reportRepository->findOrFail($id)->update([
            'fileName' => $fileName,
            'fileOriginalName' => $fileOriginalName,
            'sentAt' => (new \DateTime())->format('Y-m-d H:i:s')
        ]);

        return response()->json([
            'message' => "O arquivo <b>{$fileOriginalName}</b> foi enviado com sucesso!"
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {
        $report = $this->reportRepository->findById($id);
        $path = $this->getDirPath($report->companyId, $report->referenceDate);
        return response()->download($path . $report->fileName);
    }

}