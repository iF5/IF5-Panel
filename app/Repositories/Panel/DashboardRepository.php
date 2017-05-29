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


            //https://stackoverflow.com/questions/28319240/laravel-how-to-use-derived-tables-subqueries-in-the-laravel-query-builder
            $whereLike = ($keyword) ? "WHERE p.name LIKE '%{$keyword}%'" : null;

            $documentsByEmployees = \DB::table('documents')->selectRaw('
                employees_has_documents.documentId,
                count(employees_has_documents.documentId) AS documentQuantity,
                employees.providerId
            ')->leftJoin('employees_has_documents', function($join){
                $join->on('employees_has_documents.documentId', '=', 'documents.id');
            })->join('employees', function($join){
                $join->on('employees.id', '=', 'employees_has_documents.employeeId');
            })->where([
                ['employees_has_documents', '=', 1]
            ])->groupBy('documents.id', 'employees.providerId');



            $b = \DB::selectRaw('
                a.documentId,
                a.documentQuantity
            ')->from(\DB::raw("({$documentsByEmployees->toSql()}) AS a"))->toSql();

        dd($b);

            $q = "SELECT
                    a.documentId,
                    a.documentQuantity,
                    b.providerId,
                    b.providerName,
                    b.employeeQuantity
                FROM (
                    (
                        SELECT
                            ehd.documentId,
                            count(ehd.documentId) AS documentQuantity,
                            e.providerId
                        FROM documents AS d
                        LEFT JOIN employees_has_documents AS ehd
                          ON ehd.documentId = d.id
                        INNER JOIN employees AS e
                          ON e.id = ehd.employeeId
                        WHERE
                          ehd.validated = 1
                        GROUP BY d.id, e.providerId
                    ) AS a,
                    (
                        SELECT
                            p.id AS providerId,
                            p.name AS providerName,
                            COUNT(e.id) AS employeeQuantity
                        FROM providers AS p
                        INNER JOIN employees AS e
                          ON e.providerId = p.id
                        {$whereLike}
                        GROUP BY p.id
                        LIMIT {$this->limit}
                    ) AS b
                ) WHERE a.providerId = b.providerId;";

            return \DB::select($q);


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