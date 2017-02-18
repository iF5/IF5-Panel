<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class ReportController
{

    public function index()
    {
        return view('panel.report.form');
    }

}