<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\DocumentTrait;
use App\Repositories\Panel\DocumentRepository;
use App\Services\BreadcrumbService;


class DocumentCompanyController extends Controller
{

    use DocumentTrait;

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
     * @param DocumentRepository $documentRepository
     * @param BreadcrumbService $breadcrumbService
     */
    public function __construct(
        DocumentRepository $documentRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->documentRepository = $documentRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @param null $action
     * @return string
     */
    public function getRoute($action = null)
    {
        return sprintf('document-companies.%s', $action);
    }

    /**
     * @return int
     */
    protected function getEntityGroup()
    {
        return 1;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Documentos de clientes';
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            $this->logTitle() => route('document-companies.index'),
            $location => null
        ])->get();
    }

}
