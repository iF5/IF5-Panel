<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class DashboardController
{

    public function index()
    {
        return view('panel.dashboard.index');
    }

    public function employee()
    {
        return view('panel.dashboard.employee');
    }

}