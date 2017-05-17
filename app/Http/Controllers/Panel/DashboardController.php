<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
       $this->authorize('isProvider');

       return view('panel.dashboard.index');

    }

    public function home()
    {
        return view('panel.dashboard.home');
    }

    public function employee()
    {
        return view('panel.dashboard.employee');
    }

}