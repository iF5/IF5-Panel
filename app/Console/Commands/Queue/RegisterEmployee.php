<?php

namespace App\Console\Commands\Queue;

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

        $data = $this->csvService->setFilePath(storage_path() .'/upload/queue/register/employees/test.csv')->get();

        dd($data);

    }
}
