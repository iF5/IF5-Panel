<?php

namespace App\Http\Controllers\Panel;

use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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