<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('panel.home.index');
    }
}