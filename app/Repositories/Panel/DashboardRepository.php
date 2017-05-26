<?php

namespace App\Repositories\Panel;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardRepository
{

    /**
     * @return mixed
     */
    public function findDocumentAndEmployeeByProviders()
    {
        try {

            return \DB::select("SELECT
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
                        GROUP BY p.id
                    ) AS b
                ) WHERE a.providerId = b.providerId;");

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}