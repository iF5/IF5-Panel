<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * @var string
     */
    protected $login;


    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->login = Request::input('login');
        Request::merge([
            'email' => $this->login,
            'name' => $this->login
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            'login' => 'required', 'password' => 'required',
        ]);
    }

    /**
     * @return string
     */
    public function username()
    {
        return filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    }

}
