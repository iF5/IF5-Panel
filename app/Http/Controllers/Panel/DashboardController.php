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

        $providers = [];

        foreach($join as $j){
            $providers[$j->providerId] = [
                'providerName' => $j->providerName,
                'employeeQuantity' => $j->employeeQuantity,
                'documents' => []
            ];
        }

        $totalProvider = count($providers);
        for($i = 1; $i <= $totalProvider; $i++) {
            for ($j = 1; $j <= $total; $j++) {
                $providers[$i]['documents'][$j] = 0;
            }
        }

        foreach($join as $j){
            $providers[$j->providerId]['documents'][$j->documentId] = $j->documentQuantity;
        }


/*
        foreach($join as $j){
            $documentsValues = [];
            for($i = 1; $i <= $total; $i++){
                $documentsValues[$i] = 0;
                if((int) $j->documentId === $i){
                    $documentsValues[$i] = $j->documentQuantity;
                }
            }
            $arr[$j->providerId] = [
                'providerName' => $j->providerName,
                'employeeQuantity' => $j->employeeQuantity,
                'documents' => $documentsValues
            ];
            $providers[$j->providerId]['documents'][] = [

            ];
        }
*/


        return view('panel.dashboard.index', [
            'documentsTitle' => $documents,
            'providers' => $providers
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