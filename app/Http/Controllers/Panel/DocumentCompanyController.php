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
     * @return string
     */
    protected function logTitle()
    {
        return 'Documentos de clientes';
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return 'document-companies';
    }

    /**
     * @return int
     */
    public function getEntityGroup()
    {
        return 1;
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            'Documentos de clientes' => route('document-companies.index'),
            $location => null
        ])->get();
    }

}
