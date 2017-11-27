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
        try {
            $providers = $this->providerRepository->findAll();
            foreach ($providers as $provider) {
                $this->providers[$provider->id] = $provider;
            }
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function getAllEmployees()
    {
        try {
            $employees = $this->employeeRepository->findAll();
            foreach ($employees as $employee) {
                $this->employees[$employee->id] = $employee;
            }
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function getAllDocuments()
    {
        try {
            $documents = $this->documentRepository->all();
            foreach ($documents as $document) {
                $this->documents[$document->id] = $document;
            }
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function readDocumentStorage($dir = false, $iter=0)
    {
        try {
            ini_set('memory_limit', '1024M');
            $dirBkp = "";
            if (!$dir) {
                $dir = storage_path() . "/upload/documents/";
            }

            $dirBkp = storage_path() . "/upload/bkp/";
            if (!file_exists($dirBkp)) {
                if (mkdir($dirBkp, 0777)) {
                    //echo "CRIOU DIR ", $dirBkp, "\n";
                } else {
                    //echo "NAO CRIOU DIR ", $dirBkp, "\n";
                }
            } else {
                //echo "DIRETORIO BKP: ", $dirBkp, "\n";
            }

            if ($handle = opendir($dir)) {
                echo "Directory handle: $handle\n";
                //echo "Entries:\n";

                while (false !== ($entry = readdir($handle))) {
                    if ($entry == "." || $entry == "..") continue;
                    $path = $dir . $entry . "/";

                    echo "DIR: ", $dir, "\nENTRY: ", $entry, "\n";
                    echo "PATH: ", $path, "\n";
                    echo "ITER SWITCH: ", $iter, "\n";

                    switch ($iter) {
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

                    if (is_dir($path)) {

                        echo "Eh diretorio: $path\n";
                        echo "ITER: ", $iter, "\n";

                        $iter++;
                        $this->readDocumentStorage($path, $iter);
                    } else {
                        /*$this->monthPath = $this->removeAccentuation($this->monthPath);

                        if (!file_exists($this->monthPath)) {
                            if (mkdir($this->monthPath, 0777, true)) {
                                //echo "CRIOU O DIR ", $this->monthPath, "\n";
                            } else {
                                //echo "NAO CRIOU O DIR ", $this->monthPath, "\n";
                            }
                        }

                        $filePath = substr($path, 0, strlen($path) - 1);

                        if (file_exists($this->monthPath)) {
                            $cmd = "cp " . $filePath . " " . $this->monthPath;
                            echo $cmd, "\n";
                            exec($cmd);
                        }*/
                    }
                }
                closedir($handle);
            }
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    function removeAccentuation($string){
        try {
            return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/[\s]/"),
                array("a", "A", "e", "E", "i", "I", "o", "O", "u", "U", "n", "N", "_"), $string);
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function providerPath($dir, $subDir)
    {
        try {
            if(!array_key_exists ( $subDir , $this->providers)) return false;
            return $dir . $this->providers[$subDir]->name . "/";
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function employeePath($dir, $subDir)
    {
        try {
            if(!array_key_exists ( $subDir , $this->employees)) return false;
            return $dir . $this->employees[$subDir]->name . "/";
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function documentPath($dir, $subDir)
    {
        try {
            if(!array_key_exists ( $subDir , $this->documents)) return false;
            return $dir . $this->documents[$subDir]->name . "/";
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function yearPath($dir, $subDir)
    {
        try {
            return $dir . $subDir . "/";
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }

    protected function monthPath($dir, $subDir)
    {
        try {
            return $dir . $subDir . "/";
        }catch(Exception $e){
            echo $e->getMessage(), " --- in line: ", $e->getLine();
        }
    }
}
