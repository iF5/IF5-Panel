<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
       //$this->authorize('isProvider');

        $documents = \DB::table('documents')->get();
        $total = count($documents);

        $join = \DB::select("SELECT
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

        $arr = [];
        $values = [];
        foreach($join as $j){
            for($i = 1; $i <= $total; $i++){
                if($j->documentId === $i){
                    $values = [
                        'providerName' => $j->providerName,
                        'employeeQuantity' => $j->employeeQuantity,
                        'documentQuantity' => $j->documentQuantity
                    ];
                }else{
                    $values = [
                        'providerName' => $j->providerName,
                        'employeeQuantity' => $j->employeeQuantity,
                        'documentQuantity' => 0
                    ];
                }
            }
            $arr[$j->providerId][] = $values;
        }

        dd($arr);

        dd('END');

        return view('panel.dashboard.index', [
            'documentsTitle' => $documents,
            'total' => $total
        ]);
        /**
        SELECT
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
        ) WHERE a.providerId = b.providerId;

         */

    }

    public function employee()
    {
        return view('panel.dashboard.employee');
    }

}