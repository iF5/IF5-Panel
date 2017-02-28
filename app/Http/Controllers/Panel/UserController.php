<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class UserController
{

    public function index()
    {
        return view('panel.user.list');
    }

    public function create()
    {
        return view('panel.user.form');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('panel.user.form', [
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
