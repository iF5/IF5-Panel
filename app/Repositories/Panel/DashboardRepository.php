<?php

namespace App\Repositories\Panel;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardRepository
{

    private $limit = 20;


    /**
     * @param null $keyword
     * @return mixed
     */
    public function findDocumentAndEmployeeByProviders($keyword = null)
    {
        try {
            //Sub query
            $documentsByEmployees = \DB::table('documents')->selectRaw('
                employees_has_documents.documentId,
                count(employees_has_documents.documentId) AS documentQuantity,
                employees.providerId
            ')->leftJoin('employees_has_documents', function ($join) {
                $join->on('employees_has_documents.documentId', '=', 'documents.id');
            })->join('employees', function ($join) {
                $join->on('employees.id', '=', 'employees_has_documents.employeeId');
            })->where([
                ['employees_has_documents.validated', '=', '?']
            ])->groupBy('documents.id', 'employees.providerId');

            //Sub query
            $employeesByProviders = \DB::table('providers')->selectRaw('
                providers.id AS providerId,
                providers.name AS providerName,
                count(employees.id) AS employeeQuantity
            ')->join('employees', function ($join) {
                $join->on('employees.providerId', '=', 'providers.id');
            });
            if ($keyword) {
                $employeesByProviders->where('providers.name', 'like', '?');
            }
            $employeesByProviders->groupBy('providers.id')->limit($this->limit);

            //Query final
            return \DB::table(null)->selectRaw('
                a.documentId,
                a.documentQuantity,
                b.providerId,
                b.providerName,
                b.employeeQuantity
            ', [1, "%{$keyword}%"])->from(\DB::raw("
                ({$documentsByEmployees->toSql()}) AS a, ({$employeesByProviders->toSql()}) AS b
             "))
                ->whereRaw('a.providerId = b.providerId')
                ->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return mixed
     */
    public function findDocumentAndEmployeeByProviderId($providerId)
    {
        try {

            return \DB::table('documents')->selectRaw('
                employees_has_documents.documentId,
                count(employees_has_documents.documentId) AS documentQuantity,
                employees.id AS employeeId,
                employees.name AS employeeName
            ', [$providerId, 1])->leftJoin('employees_has_documents', function ($join) {
                $join->on('employees_has_documents.documentId', '=', 'documents.id');
            })->join('employees', function ($join) {
                $join->on('employees.id', '=', 'employees_has_documents.employeeId');
            })->where([
                ['employees.providerId', '=', '?'],
                ['employees_has_documents.validated', '=', '?']
            ])->groupBy('documents.id', 'employees.id')->get();

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}