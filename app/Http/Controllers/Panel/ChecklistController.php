<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class ChecklistController
{

    public function index()
    {
        return view('panel.checklist.list');
    }
}
