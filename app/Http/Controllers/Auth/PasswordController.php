<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\UserRepository;
use Illuminate\Http\Request;
use SendGrid;

use App\Http\Constants\SendGrid AS SendGridConst;

class PasswordController extends Controller
{


    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * PasswordController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        //$this->sendgrid();
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
                'success' => false,
                'message' => sprintf('O e-mail %s n&atilde;o encontrado!', $email)
            ]);
        }

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'link' => route('password-reset.edit', [
                'token' => sha1(sha1($user->email))
            ])
        ];

        $sendGrid = $this->sendGrid($data);

        $redirectData = [
            'success' => true,
            'message' => 'Solicitação realizada com sucesso, uma mensagem foi enviada para seu e-mail.'
        ];

        if (!(int)$sendGrid === 200) {
            $redirectData = [
                'success' => false,
                'message' => 'Erro interno por favor tenter mais tarde'
            ];
        }

        return redirect()->route('password-reset.edit')->with($redirectData);

    }

    protected function sendGrid($data)
    {
        $from = new SendGrid\Email(SendGridConst::SENDER_NAME, SendGridConst::SENDER_EMAIL);
        $to = new SendGrid\Email($data['name'], $data['email']);

        $html = \View::make('auth.passwords.message', $data)->render();
        $content = new SendGrid\Content("text/html", $html);
        $mail = new SendGrid\Mail($from, SendGridConst::PASSWORD_RESET_SUBJECT, $to, $content);
        $sg = new \SendGrid(SendGridConst::API_KEY);

        $response = $sg->client->mail()->send()->post($mail);
        return $response->statusCode();
    }

    /**
     * @param array $data
     */
    protected function sendEmail($data)
    {
        \Mail::send('auth.passwords.mail', $data, function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Redefini&ccedil;&atilde;o de senha')
                ->from('robot@btg360.com.br');
        });
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
