<?php

namespace App\Console\Commands\Queue;

use App\Facades\Employee;
use App\Models\Crud\Create;
use App\Services\CsvService;
use Illuminate\Console\Command;

class RegisterEmployee extends Command
{

    use Create;

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
     * @var CsvService
     */
    protected $csvService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CsvService $csvService)
    {
        parent::__construct();

        $this->csvService = $csvService;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $a = $this->insertIgnoreBatch('queue_register_employees', [
            [
                'fileName' => 'test.csv',
                'originalFileName' => '12873183712873.csv',
                'providerId' => 12,
                'createdAt' => $now
            ],
            [
                'fileName' => 'test2.csv',
                'originalFileName' => '034827439482048.csv',
                'providerId' => 12,
                'createdAt' => $now
            ]
        ]);

        dd($a);

        //$data = $this->csvService->setFilePath(Employee::getFilePathRegisterBatch() . '/test.csv')->get();

        //dd($data);
        /**
         * 1 - Vai na fila pega os dados para processar
         * 2 - Pega o caminho do csv e faz o parse
         * 3 - Salva na tabela de funcionários
         * 4 - Recupera os ids salvos e salva todos os documentos na tabela de documentos
         * 5 - Atualiza a fila de processamento
         */

    }
}
