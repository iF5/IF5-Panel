<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class CompanyController
{

    public function index()
    {
        return view('panel.company.form');
    }

}