<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $documentsTitle = \DB::table('documents')->get();

        return view('panel.home.index', [
            'documentsTitle' => $documentsTitle
        ]);
    }
}

/*




 */