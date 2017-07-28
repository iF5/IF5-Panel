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
        $user = $this->userRepository->findByEmail($email);

        $data = [
            'name' => $user->name,
            'link' => route('password-reset.edit', [
                'token' => sha1(sha1($user->email))
            ])
        ];

        return view('auth.mail.password-reset', $data);

        \Mail::send('auth.mail.password-reset', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Redefini&ccedil;&atilde;o de senha')
                ->from('robot@btg360.com.br');
        });

        return redirect()->route('password-reset.index')->with([
            'success' => true,
            'message' => 'Solicitação realizada com sucesso, para proseguir olhe seu email'
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
