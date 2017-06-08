<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Traits\AuthTrait;

class HomeController extends Controller
{

    use AuthTrait;

    /**
     * @var array
     */
    protected $redirects = [
        'admin' => 'dashboard.index',
        'company' => 'dashboard.index',
        'provider' => 'employee.index'
    ];

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return redirect()->route($this->redirects[$this->getRole()]);
    }

}