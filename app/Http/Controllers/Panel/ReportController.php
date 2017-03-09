<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController
{

    public function index()
    {
        return view('panel.report.form');
    }

    public function upload(Request $request)
    {
        $dir = public_path() . '/uploads/';
        $files = $request->file('file');

        foreach ($files as $file) {
            $file->move($dir, $file->getClientOriginalName());
        }

        return response()->json([
            'message' => 'Os Arquivos foram enviados com sucesso!'
        ]);

    }

}