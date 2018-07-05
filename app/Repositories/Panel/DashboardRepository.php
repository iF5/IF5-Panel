<?php

namespace App\Repositories\Panel;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Traits\AuthTrait;
use App\Models\Company;

class DashboardRepository
{

    use AuthTrait;

    private $limit = 20;

    private $bindings = [];

    public function getCompanies()
    {
        try {
            $stmt = \DB::table('companies')->select('id', 'name');
            return $stmt->get();
        } catch(\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    public function getDocumentCompanies($id = null)
    {
        try {
            $stmt = \DB::table('companies_has_documents')->selectRaw('
                companies_has_documents.companyId,
                companies_has_documents.documentId,
                document_checklists.status
            ')->leftJoin('documents', function($join){
                $join->on('companies_has_documents.documentId', '=', 'documents.id');
            })->leftjoin('document_checklists', function($join){
                $join->on('companies_has_documents.documentId', '=', 'document_checklists.documentId');
                $join->on('companies_has_documents.companyId', '=', 'document_checklists.entityId');
            });

            if ($id) {
                $stmt->where('companies_has_documents.companyId', '=', $id);
            }

            return $stmt->get();
        } catch(\Exception $e) {
            //echo $e->getMessage(), "<br>";
            throw new ModelNotFoundException;
        }
    }

    public function getProviders($companyId = null)
    {
        try {
            if ($companyId) {
                $stmt = \DB::table('providers_has_companies')
                    ->select('providers.id', 'providers.name')
                    ->where('providers_has_companies.companyId', '=', $companyId)
                    ->join('providers', 'providers_has_companies.providerId', 'providers.id');
            } else {
                $stmt = \DB::table('providers')->select('providers.id', 'providers.name');
            }

            return $stmt->get();
        } catch(\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    public function getDocumentProviders($companyId = null)
    {
        try {
            $stmt = \DB::table('providers_has_documents')->selectRaw('
                providers_has_companies.companyId,
                providers_has_documents.documentId,
                document_checklists.status
            ')->leftJoin('documents', function($join){
                $join->on('providers_has_documents.documentId', '=', 'documents.id');
            })->leftjoin('document_checklists', function($join){
                $join->on('providers_has_documents.documentId', '=', 'document_checklists.documentId');
            })->join('providers_has_companies', function($join){
                $join->on('providers_has_companies.providerId', '=', 'providers_has_documents.providerId');
            });

            if ($companyId) {
                $stmt->where('providers_has_companies.companyId', '=', $companyId);
            }
            return $stmt->get();
        } catch(\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    public function getDocumentEmployees($companyId = null)
    {
        try {
            $stmt = \DB::table('employees_has_documents')->selectRaw('
                providers_has_companies.companyId,
                employees_has_documents.documentId,
                employees_has_documents.employeeId,
                employees.providerId,
                document_checklists.status
            ')->leftJoin('documents', function($join){
                $join->on('employees_has_documents.documentId', '=', 'documents.id');
            })->leftjoin('document_checklists', function($join){
                $join->on('employees_has_documents.documentId', '=', 'document_checklists.documentId');
                $join->on('employees_has_documents.employeeId', '=', 'document_checklists.entityId');
            })->join('employees', function($join){
                $join->on('employees_has_documents.employeeId', '=', 'employees.id');
            })->join('providers_has_companies', function($join){
                $join->on('providers_has_companies.providerId', '=', 'employees.providerId');
            });

            if ($companyId) {
                $stmt->where('providers_has_companies.companyId', '=', $companyId);
            }
            //dd($stmt->toSql());
            return $stmt->get();
        } catch(\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    public function getCompanyById($id)
    {
        $company = New Company();

        return $company->find($id);
    }
}
