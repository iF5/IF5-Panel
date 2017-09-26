<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\DocumentTrait;
use App\Repositories\Panel\DocumentRepository;
use App\Repositories\Panel\DocumentTypeRepository;
use App\Services\BreadcrumbService;


class DocumentEmployeeController extends Controller
{

    use DocumentTrait;

    /**
     * @var DocumentTypeRepository
     */
    private $documentTypeRepository;

    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * DocumentCompanyController constructor.
     * @param DocumentTypeRepository $documentTypeRepository
     * @param DocumentRepository $documentRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        DocumentTypeRepository $documentTypeRepository,
        DocumentRepository $documentRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->documentTypeRepository = $documentTypeRepository;
        $this->documentRepository = $documentRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @param null $action
     * @return string
     */
    public function getRoute($action = null)
    {
        return sprintf('document-employees.%s', $action);
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return 3;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Documentos de funcion&aacute;rios';
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            $this->logTitle() => route($this->getRoute('index')),
            $location => null
        ])->get();
    }

}
