<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\ProviderRepository;

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

    protected $providers;

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getAllProviders();
        $this->readDocumentStorage();
    }

    protected function getAllProviders()
    {
        $providers = $this->providerRepository->findAll();
        foreach($providers as $provider){
            $this->providers[$provider->id] = $provider;

        }
    }

    protected function readDocumentStorage($dir = false)
    {
        ini_set('memory_limit', '1024M');
        if(!$dir) {
            $dir = storage_path() . "/upload/documents/";
        }

        if ($handle = opendir($dir)) {
            echo "Directory handle: $handle\n";
            echo "Entries:\n";

            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") continue;

                $path = $dir . $entry . "/";

                $providerPath = $this->providerPath($dir, $entry);


                if(is_dir($path)) {
                    echo "Eh diretorio: $path\n";
                    $this->readDocumentStorage($path);
                } else {
                    echo "Nao eh diretorio: $path\n";
                }
            }
            closedir($handle);
        }
    }

    protected function providerPath($dir, $subDir)
    {
        return $dir . $this->providers[$subDir]->name . "/";
    }
}
