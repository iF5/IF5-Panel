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
        return view('auth.passwords.email');
    }

    public function check(Request $request)
    {
        $email = trim($request->get('email'));
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return redirect()->route('password-reset.index')->with([
                'success' => false,
                'message' => sprintf('O e-mail %s n&atilde;o encontrado!', $email)
            ]);
        }

        $data = [
            'name' => $user->name,
            'link' => route('password-reset.edit', [
                'token' => sha1(sha1($user->email))
            ])
        ];

        return view('auth.passwords.mail', $data);


        /**
         * return redirect()->route('auth.passwords.email')->with([
         * 'success' => true,
         * 'message' => 'Solicitação realizada com sucesso, para proseguir olhe seu email'
         * ]);
         * */

    }

    protected function sendEmail($data)
    {
        \Mail::send('auth.passwords.mail', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Redefini&ccedil;&atilde;o de senha')
                ->from('robot@btg360.com.br');
        });
    }

    public function edit($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function update()
    {
        return view('auth.password-reset');
    }

}
