<?php

namespace App\Http\Controllers\Panel;

use App\Facades\Money;
use App\Facades\Period;
use App\Http\Traits\AuthTrait;
use App\Http\Traits\LogTrait;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\EmployeeChildrenRepository;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\RelationshipRepository;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\Employee;
use App\Services\UploadService;
use App\Services\CsvService;

class EmployeeController extends Controller
{

    use AuthTrait, LogTrait;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @var EmployeeChildrenRepository
     */
    private $employeeChildrenRepository;

    /**
     * @var RelationshipRepository
     */
    private $relationshipRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * @var array
     */
    private $states;

    /**
     * @var UploadService
     */
    private $uploadService;

    /**
     * @var CsvService
     */
    private $csvService;

    public function __construct(
        EmployeeRepository $employeeRepository,
        ProviderRepository $providerRepository,
        DocumentRepository $documentRepository,
        EmployeeChildrenRepository $employeeChildrenRepository,
        RelationshipRepository $relationshipRepository,
        BreadcrumbService $breadcrumbService,
        UploadService $uploadService,
        CsvService $csvService
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->providerRepository = $providerRepository;
        $this->documentRepository = $documentRepository;
        $this->employeeChildrenRepository = $employeeChildrenRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->breadcrumbService = $breadcrumbService;
        $this->uploadService = $uploadService;
        $this->csvService = $csvService;
        $this->states = \Config::get('states');
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Funcion&aacute;rios';
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('provider', $this->providerRepository->findById($id));
        return redirect()->route('employee.index');
    }

    /**
     * @return int
     */
    protected function getProviderId()
    {
        return (in_array(\Auth::user()->role, ['admin', 'company']))
            ? \Session::get('provider')->id
            : \Auth::user()->providerId;
    }

    /**
     * @return mixed
     */
    protected function getDocuments()
    {
        return $this->documentRepository->findAllByEntity(Employee::ID);
    }

    /**
     * @return mixed
     */
    protected function getCompanies()
    {
        return $this->providerRepository->findCompaniesByProvider($this->getProviderId());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $employees = ($keyword)
            ? $this->employeeRepository->findLike($this->getProviderId(), 'name', $keyword)
            : $this->employeeRepository->findOrderBy($this->getProviderId());

        return view('panel.employee.list', [
            'keyword' => $keyword,
            'breadcrumbs' => $this->getBreadcrumb(),
            'employees' => $employees
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function formRequest(Request $request)
    {
        $data = $request->all();
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $data['salaryCap'] = Money::toDecimal($data['salaryCap']);
        $data['status'] = $this->isAdmin();
        $data['updatedAt'] = $now;
        $data['hiringDate'] = Period::format($data['hiringDate'], 'Y-m-d');
        $data['birthDate'] = Period::format($data['birthDate'], 'Y-m-d');
        $data['startAt'] = Period::format($data['startAt'], 'Y-m-d');
        $data['documents'] = isset($data['documents']) ? $data['documents'] : [];
        $data['companies'] = isset($data['companies']) ? $data['companies'] : [];

        if (strtoupper($request->getMethod()) === 'POST') {
            $data['createdAt'] = $now;
        }

        return $data;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->employeeRepository->providerId = $this->getProviderId();
        $this->employeeRepository->hasChildren = 0;

        return view('panel.employee.form', [
            'employee' => $this->employeeRepository,
            'documents' => $this->getDocuments(),
            'selectedDocuments' => [],
            'companies' => $this->getCompanies(),
            'selectedCompanies' => [],
            'states' => $this->states,
            'route' => 'employee.store',
            'method' => 'POST',
            'parameters' => [],
            'breadcrumbs' => $this->getBreadcrumb('Cadastrar')
        ]);
    }

    /**
     * @param array $data
     * @param int $employeeId
     * @return mixed
     */
    protected function childrenStore($data, $employeeId)
    {
        if (!(int)$data['hasChildren']) {
            return false;
        }

        $today = new \DateTime();
        $total = count($data['children']['name']);
        $children = [];
        for ($i = 0; $i < $total; $i++) {
            $name = $data['children']['name'][$i];
            $birthDate = Period::format($data['children']['birthDate'][$i], 'Y-m-d');
            $age = ($today->format('Y-m-d') - $birthDate);
            if ($name && $birthDate && (($age >= 0) && ($age < 18))) {
                $children[] = [
                    'name' => $name,
                    'birthDate' => $birthDate,
                    'employeeId' => $employeeId,
                    'createdAt' => $today->format('Y-m-d H:i:s')
                ];
            }
        }

        $this->employeeChildrenRepository->createByEmployee($employeeId, $children);
        return true;
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
            $request, $this->employeeRepository->rules(), $this->employeeRepository->messages()
        );

        $data = $this->formRequest($request);
        $employee = $this->employeeRepository->create($data);
        $this->childrenStore($data, $employee->id);
        $this->employeeRepository->attachCompanies([$employee->id], $data['companies']);
        $this->employeeRepository->attachDocuments([$employee->id], $data['documents']);
        $this->createLog('POST', $data);

        return redirect()->route('employee.create')->with([
            'success' => true,
            'message' => 'Funcion&aacute;rio cadastrado com sucesso!',
            'route' => 'employee.show',
            'id' => $employee->id
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
        $employee = $this->employeeRepository->find($id);
        $companies = $this->providerRepository->findCompaniesByProvider($this->getProviderId());

        return view('panel.employee.show', [
            'employee' => $employee,
            'companies' => $companies,
            'documents' => $this->documents,
            'selectedDocuments' => $this->employeeRepository->findDocuments($id),
            'breadcrumbs' => $this->getBreadcrumb('Visualizar')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->employeeRepository->findOrFail($id);

        return view('panel.employee.form', [
            'employee' => $employee,
            'documents' => $this->getDocuments(),
            'selectedDocuments' => $this->employeeRepository->listIdDocuments($id),
            'companies' => $this->getCompanies(),
            'selectedCompanies' => $this->employeeRepository->listIdCompanies($id),
            'states' => $this->states,
            'route' => 'employee.update',
            'method' => 'PUT',
            'parameters' => [$id],
            'breadcrumbs' => $this->getBreadcrumb('Atualizar')
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
            $request, $this->employeeRepository->rules($id), $this->employeeRepository->messages()
        );

        $data = $this->formRequest($request);
        $this->employeeRepository->findOrFail($id)->update($data);
        $this->employeeRepository->attachCompanies([$id], $data['companies']);
        $this->employeeRepository->attachDocuments([$id], $data['documents']);
        $this->createLog('PUT', $data);

        return redirect()->route('employee.edit', $id)->with([
            'success' => true,
            'message' => 'Funcion&aacute;rio atualizado com sucesso!',
            'route' => 'employee.show',
            'id' => $id
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
        $this->employeeRepository->destroy($id);
        $this->employeeRepository->detachDocuments($id);
        $this->employeeRepository->detachCompanies($id);
        $this->createLog('DELETE', ['id' => $id]);

        return redirect()->route('employee.index');
    }

    /**
     * @param $employeeId
     * @param $layoffType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function layoff($employeeId, $layoffType)
    {
        $layoffType = ((int)$layoffType !== 2) ? 1 : 2;
        $label = [1 => 'demissão', 2 => 'afastamento'];

        return view('panel.employee.layoff', [
            'employeeId' => $employeeId,
            'employeeName' => 'Fulano de tal',
            'layoffType' => $layoffType,
            'label' => $label[$layoffType]
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
                $company->fantasyName => route('company.show', $company->id)
            ];
        }

        if (\Session::has('provider')) {
            $provider = \Session::get('provider');
            $data['Prestadores de servi&ccedil;os'] = route('provider.index');
            $data[$provider->fantasyName] = route('provider.show', $provider->id);
        }

        $data['Funcion&aacute;rios'] = route('employee.index');
        $data[$location] = null;

        return $this->breadcrumbService->push($data)->get();
    }

    #IN BATCH

    /**
     * Register
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function registerBatchIndex()
    {
        $registers = $this->relationshipRepository->findAll('register_batch_employees', [
            'providerId' => $this->getProviderId()
        ], 'DESC');

        return view('panel.employee.register', [
            'breadcrumbs' => $this->getBreadcrumb('Cadastrar em lote'),
            'registers' => $registers->data,
            'statusClass' => ['text-warning', 'text-success', 'text-danger'],
            'delimiters' => [';' => 'Ponto e v&iacute;rgula', ',' => 'V&iacute;rgula']
        ]);
    }

    /**
     * Register upload
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerBatchUpload(Request $request)
    {
        $file = $request->file('file');
        $fileName = sprintf('%s.csv', sha1(uniqid(rand(), true)));
        $extension = ['csv'];
        $upload = $this->uploadService
            ->setDir(Employee::getFilePathRegisterBatch())
            ->setAllowedExtensions(
                $extension, sprintf('S&oacute; &eacute; permitido arquivo: %s', implode($extension))
            )->move(
                $file, $fileName, sprintf('O arquivo %s foi enviado com sucesso', $file->getClientOriginalName())
            );

        if (!$upload->error) {
            $now = (new \DateTime())->format('Y-m-d H:i:s');
            $this->relationshipRepository->create('register_batch_employees', [
                'name' => $request->get('name'),
                'delimiter' => $request->get('delimiter'),
                'fileName' => $fileName,
                'originalFileName' => $file->getClientOriginalName(),
                'message' => 'Aguardando ser processado',
                'providerId' => $this->getProviderId(),
                'createdAt' => $now,
                'updatedAt' => $now
            ]);
        }

        $this->createLog('POST', (array)$upload);
        return response()->json($upload);
    }

    /**
     * Register run
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function registerBatchRun($id)
    {
        $providerId = $this->getProviderId();
        $register = $this->relationshipRepository->first('register_batch_employees', [
            ['id', $id],
            ['providerId', $providerId],
            ['status', 0]
        ]);

        if (!$register) {
            return response()->json(['error' => true, 'message' => 'Register not found']);
        }

        $csv = $this->getCsvData($register->data);
        if($csv->error) {
            $this->relationshipRepository->update('register_batch_employees', [
                'status' => 2,
                'message' => 'N&atilde;o foi poss&iacute;vel processar o csv, por favor examine o mesmo e tente novamente.',
                'debugMessage' => $csv->message
            ], [['id', $id]]);
            return response()->json(['error' => true, 'message' => 'Csv error']);
        }

        $employees = $this->employeeRepository->register($csv->data);
        $this->employeeRepository->attachDocuments($employees, $this->documentRepository->idList(Employee::ID));
        $this->employeeRepository->attachCompanies(
            $employees, $this->providerRepository->listIdCompanies($providerId)
        );
        $this->relationshipRepository->update('register_batch_employees', [
            'status' => 1,
            'message' => 'Funcion&aacute;rios cadastrados com sucesso',
            'affectedItems' => json_encode($employees)
        ], [['id', $id]]);

        $this->createLog('POST', $employees);
        return response()->json(['error' => false, 'message' => 'Success']);
    }


    /**
     * Csv
     *
     * @param mixed $register
     * @return object
     */
    protected function getCsvData($register)
    {
        $csv = $this->csvService
            ->setDelimiter($register->delimiter)
            ->setFilePath(Employee::getFilePathRegisterBatch($register->fileName))
            ->get();

        if (!$csv->error) {
            $fill = array_fill_keys($this->employeeRepository->getFillable(), '');
            $fill['providerId'] = $register->providerId;
            $now = (new \DateTime())->format('Y-m-d H:i:s');
            $fill['createdAt'] = $now;
            $fill['updatedAt'] = $now;
            $fill['status'] = true;
            foreach ($csv->data as $key => &$value) {
                $value = array_merge($fill, array_intersect_key($value, $fill));
                $value['birthDate'] = Period::format($value['birthDate'], 'Y-m-d');
                $value['salaryCap'] = Money::toDecimal($value['salaryCap']);
                $hiringDate = Period::format($value['hiringDate'], 'Y-m-d');
                $value['hiringDate'] = $hiringDate;
                $value['startAt'] = $hiringDate;
            }
        }

        return $csv;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function registerBatchDestroy($id)
    {
        $register = $this->relationshipRepository->first('register_batch_employees', [['id', $id]]);
        if (!$register->error) {
            $data = ['id' => $id];
            unlink(Employee::getFilePathRegisterBatch($register->data->fileName));
            $this->relationshipRepository->destroy('register_batch_employees', $data);
            $this->createLog('DELETE', $data);
        }

        return redirect()->route('employee.register.index');
    }


}
