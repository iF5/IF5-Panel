<?php

namespace App\Console\Commands\Queue;

use App\Facades\Employee;
use App\Facades\Money;
use App\Facades\Period;
use App\Repositories\Batch\RegisterEmployeeRepository;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\EmployeeRepository;
use App\Services\CsvService;
use Illuminate\Console\Command;

class RegisterEmployee extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'if5:register:employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to register employees in batch';

    /**
     * @var EmployeeRepository
     */
    protected $employeeRepository;

    /**
     * @var DocumentRepository
     */
    protected $documentRepository;

    /**
     * @var RegisterEmployeeRepository
     */
    protected $registerEmployeeRepository;

    /**
     * @var CsvService
     */
    protected $csvService;

    public function __construct(
        EmployeeRepository $employeeRepository,
        DocumentRepository $documentRepository,
        RegisterEmployeeRepository $registerEmployeeRepository,
        CsvService $csvService
    )
    {
        parent::__construct();

        $this->employeeRepository = $employeeRepository;
        $this->documentRepository = $documentRepository;
        $this->registerEmployeeRepository = $registerEmployeeRepository;
        $this->csvService = $csvService;

    }

    public function registerEmployee()
    {
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $this->registerEmployeeRepository->save([
            'name' => 'Funcionarios novos',
            'delimiter' => ';',
            'fileName' => '99fdb3623cf5c6ad0283ca5c096018dd2f2ff5ad.csv',
            'originalFileName' => 'funcionarios.csv',
            'providerId' => 1,
            'createdAt' => $now,
            'updatedAt' => $now
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $registers = $this->registerEmployeeRepository->findAll();
        $documents = $this->getDocuments();
        foreach ($registers as $register) {
            $csv = $this->getCsvData($register);
            $employees = $this->employeeRepository->saveInBatch($csv->data);
            $this->employeeRepository->attachDocumentsInBatch($employees->all, $documents);
        }

        /**
         * 1 - Vai na fila pega os dados para processar OK
         * 2 - Pega o caminho do csv e faz o parse OK
         * 3 - Salva na tabela de funcionários OK
         * 4 - Recupera os ids salvos e salva todos os documentos na tabela de documentos OK
         * 5 - Atualiza a fila de processamento
         *
         * | id | fileName                                     | originalFileName | status | message | debugMessage | providerId | createdAt           |
         * +----+----------------------------------------------+------------------+--------+---------+--------------+------------+---------------------+
         * |  5 | 99fdb3623cf5c6ad0283ca5c096018dd2f2ff5ad.csv | func.csv         |      0 | NULL    | NULL         |          1 | 2018-03-20 11:59:49 |
         *
         *
         * employees
         * employees_has_documents
         */
    }

    protected function getDocuments()
    {
        $rows = $this->documentRepository->findAllByEntity(Employee::ID);
        $documents = [];
        foreach ($rows as $row) {
            $documents[] = $row->id;
        }
        return $documents;
    }

    /**
     * @param mixed $register
     * @return object
     */
    protected function getCsvData($register)
    {
        $csv = $this->csvService
            ->setDelimiter($register->delimiter)
            ->setFilePath(sprintf('%s/%s', Employee::getFilePathRegisterBatch(), $register->fileName))
            ->get();

        if (!$csv->error) {
            $fill = array_fill_keys($this->employeeRepository->getFillable(), '');
            $now = (new \DateTime())->format('Y-m-d H:i:s');
            $fill['providerId'] = $register->providerId;
            $fill['createdAt'] = $now;
            $fill['updatedAt'] = $now;
            foreach ($csv->data as $key => &$value) {
                $value = array_merge($fill, array_intersect_key($value, $fill));
                $value['birthDate'] = Period::format($value['birthDate'], 'Y-m-d');
                $value['salaryCap'] = Money::toDecimal($value['salaryCap']);
                $value['hiringDate'] = Period::format($value['hiringDate'], 'Y-m-d');
            }
        }

        return $csv;
    }
}
