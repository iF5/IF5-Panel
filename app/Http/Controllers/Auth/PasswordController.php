<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\UserRepository;
use Illuminate\Http\Request;
use App\Services\SendGridService;

class PasswordController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var SendGridService
     */
    protected $sendGridService;

    /**
     * PasswordController constructor.
     * @param UserRepository $userRepository
     * @param SendGridService $sendGridService
     */
    public function __construct(
        UserRepository $userRepository,
        SendGridService $sendGridService
    )
    {
        $this->userRepository = $userRepository;
        $this->sendGridService = $sendGridService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.passwords.email');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function check(Request $request)
    {
        $email = trim($request->get('email'));
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return redirect()->route('password-reset.index')->with([
                'success' => false, 'message' => sprintf('O e-mail %s n&atilde;o foi encontrado.', $email)
            ]);
        }

        $content = \View::make('auth.passwords.message', [
            'name' => $user->name,
            'link' => route('password-reset.edit', ['token' => sha1(sha1($user->email))])
        ])->render();

        $sendGrid = $this->sendGridService
            ->setReceiverName($user->name)
            ->setReceiverEmail($user->email)
            ->setSubject('Redefinição de senha')
            ->setContent($content)
            ->setIsTextHtml(true)
            ->send();

        return redirect()->route('password-reset.index')->with([
            'success' => $sendGrid,
            'message' => ($sendGrid)
                ? 'Solicitação realizada com sucesso, uma mensagem foi enviada para o seu e-mail.'
                : 'Erro inesperado, por favor tente mais tarde.'
        ]);
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $data = (object)$request->all();
        $user = $this->userRepository->findByDuoSha1Token($data->token);

        if (!$user) {
            return redirect()->route('password-reset.edit', ['token' => $data->token])->with([
                'success' => false,
                'message' => 'Usu&aacute;rio n&atilde;o encontrado!'
            ]);
        }

        $this->userRepository->findOrFail($user->id)->update([
            'password' => bcrypt($data->password)
        ]);

        return redirect('/login');
    }

}
