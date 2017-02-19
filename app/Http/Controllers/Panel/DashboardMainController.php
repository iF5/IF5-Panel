<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardMainController extends Controller
{
    public function index()
    {
        return view('dashboard-main');
    }
}
