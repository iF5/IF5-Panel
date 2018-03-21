<?php

namespace App\Console\Commands\Queue;

use App\Facades\Employee;
use App\Facades\Money;
use App\Facades\Period;
use App\Repositories\Panel\EmployeeRepository;
use App\Repositories\Queue\QueueRepository;
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
     * @var QueueRepository
     */
    protected $queueRepository;

    /**
     * @var CsvService
     */
    protected $csvService;

    public function __construct(
        EmployeeRepository $employeeRepository,
        CsvService $csvService,
        QueueRepository $queueRepository
    )
    {
        parent::__construct();

        $this->employeeRepository = $employeeRepository;
        $this->queueRepository = $queueRepository;
        $this->csvService = $csvService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->employeeRepository->attachDocumentsInBatch([1, 2], [12,13,14,15]);

        $queues = $this->queueRepository->getRegisterEmployee();

        foreach ($queues as $queue) {
            $csv = $this->getCsvData($queue);
            $all = $this->employeeRepository->saveInBatch($csv->data);
            print_r($all);
        }

        /**
         * 1 - Vai na fila pega os dados para processar OK
         * 2 - Pega o caminho do csv e faz o parse OK
         * 3 - Salva na tabela de funcionários OK
         * 4 - Recupera os ids salvos e salva todos os documentos na tabela de documentos
         * 5 - Atualiza a fila de processamento
         *
         * | id | fileName                                     | originalFileName | status | message | debugMessage | providerId | createdAt           |
        +----+----------------------------------------------+------------------+--------+---------+--------------+------------+---------------------+
        |  5 | 99fdb3623cf5c6ad0283ca5c096018dd2f2ff5ad.csv | func.csv         |      0 | NULL    | NULL         |          1 | 2018-03-20 11:59:49 |

         *
         */
    }

    /**
     * @param $queue
     * @return array
     */
    protected function getCsvData($queue)
    {
        $csv = $this->csvService
            ->setFilePath(sprintf('%s/%s', Employee::getFilePathRegisterBatch(), $queue->fileName))
            ->get();

        if (!$csv->error) {
            $fill = array_fill_keys($this->employeeRepository->getFillable(), '');
            $now = (new \DateTime())->format('Y-m-d H:i:s');
            $fill['providerId'] = $queue->providerId;
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
