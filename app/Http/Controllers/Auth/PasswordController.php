<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\UserRepository;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('auth.password-reset');
    }

    public function check(Request $request)
    {

        $email = trim($request->get('email'));
        $token = sha1(sha1($email));

        $a = $this->userRepository->findByEmail($email);

        dd($token);
        return redirect()->route('password-reset.index')->with([
            'success' => true,
            'message' => 'Cliente cadastrado com sucesso!'
        ]);
    }

    public function edit()
    {
        return view('auth.password-reset');
    }

    public function update()
    {
        return view('auth.password-reset');
    }

}
