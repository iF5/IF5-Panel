<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class UserController
{

    public function create()
    {
        return view('panel.user.form');
    }

}