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

            $q = "SELECT
                    ehd.documentId,
                    count(ehd.documentId) AS documentQuantity,
                    e.id AS employeeId,
                    e.name AS employeeName
                FROM documents AS d
                LEFT JOIN employees_has_documents AS ehd
                    ON ehd.documentId = d.id
                INNER JOIN employees AS e
                    ON e.id = ehd.employeeId
                WHERE
                    e.providerId = {$providerId}
                    AND ehd.validated = 1
                GROUP BY d.id, e.id;
            ";

            return \DB::select($q);

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}