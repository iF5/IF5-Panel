<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\EmployeeRepository;

class PackageDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pack:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $documentRepository;

    protected $providerRepository;

    protected $employeeRepository;

    protected $providers;

    protected $employees;

    protected $documents;

    protected $providerPath;

    protected $employeePath;

    protected $documentPath;

    protected $yearPath;

    protected $monthPath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->documentRepository = new DocumentRepository();
        $this->providerRepository = new ProviderRepository();
        $this->employeeRepository = new EmployeeRepository();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getAllDocuments();
        $this->getAllProviders();
        $this->getAllEmployees();
        $this->readDocumentStorage();
    }

    protected function getAllProviders()
    {
        $providers = $this->providerRepository->findAll();
        foreach($providers as $provider){
            $this->providers[$provider->id] = $provider;
        }
    }

    protected function getAllEmployees()
    {
        $employees = $this->employeeRepository->findAll();
        foreach($employees as $employee){
            $this->employees[$employee->id] = $employee;
        }
    }

    protected function getAllDocuments()
    {
        $documents = $this->documentRepository->all();
        foreach($documents as $document){
            $this->documents[$document->id] = $document;
        }
    }

    protected function readDocumentStorage($dir = false, $iter=0)
    {
        ini_set('memory_limit', '1024M');
        $dirBkp = "";
        if(!$dir) {
            $dir = storage_path() . "/upload/documents/";
        }

        $dirBkp = storage_path() . "/upload/bkp/";
        if(!file_exists($dirBkp)){
            if(mkdir($dirBkp, 0777)){
                echo "CRIOU DIR ", $dirBkp, "\n";
            } else {
                echo "NAO CRIOU DIR ", $dirBkp, "\n";
            }
        }

        if ($handle = opendir($dir)) {
            echo "Directory handle: $handle\n";
            echo "Entries:\n";

            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") continue;

                $path = $dir . $entry . "/";

                switch($iter){
                    case 0:
                        $this->providerPath = $this->providerPath($dirBkp, $entry);
                        break;
                    case 1:
                        $this->employeePath = $this->employeePath($this->providerPath, $entry);
                        break;
                    case 2:
                        $this->documentPath = $this->documentPath($this->employeePath, $entry);
                        break;
                    case 3:
                        $this->yearPath = $this->yearPath($this->documentPath, $entry);
                        break;
                    case 4:
                        $this->monthPath = $this->monthPath($this->yearPath, $entry);
                        break;
                }

                if(is_dir($path)) {
                    echo "Eh diretorio: $path\n";
                    $iter++;
                    $this->readDocumentStorage($path, $iter);
                } else {
                    echo "Nao eh diretorio: $path\n";
                    dd("--AQUI--");
                }
            }
            closedir($handle);
        }
    }

    protected function providerPath($dir, $subDir)
    {
        return $dir . $this->providers[$subDir]->name . "/";
    }

    protected function employeePath($dir, $subDir)
    {
        return $dir . $this->employees[$subDir]->name . "/";
    }

    protected function documentPath($dir, $subDir)
    {
        return $dir . $this->documents[$subDir]->name . "/";
    }

    protected function yearPath($dir, $subDir)
    {
        return $dir . $subDir  . "/";
    }

    protected function monthPath($dir, $subDir)
    {
        return $dir . $subDir  . "/";
    }
}
