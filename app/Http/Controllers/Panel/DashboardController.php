<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
       //$this->authorize('isProvider');

        $documentsTitle = \DB::table('documents')->get();

        return view('panel.dashboard.index', [
            'documentsTitle' => $documentsTitle,
            'total' => count($documentsTitle)
        ]);
        /**
        SELECT
        p.id,
        p.name,
        COUNT(e.id) AS employeeQuantity
        FROM providers AS p
        INNER JOIN employees AS e
        ON e.providerId = p.id
        WHERE p.name LIKE '%tok%'
        GROUP BY p.id;


        SELECT
        d.id,
        d.name,
        count(ehd.documentId) AS documentQuantity
        FROM documents AS d
        LEFT JOIN employees_has_documents AS ehd
        ON ehd.documentId = d.id
        LEFT JOIN employees AS e
        ON e.id = ehd.employeeId
        WHERE e.providerId = 1
        GROUP BY d.id;
         */

    }

    public function employee()
    {
        return view('panel.dashboard.employee');
    }

}