<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\UserRepository;
use Illuminate\Http\Request;

use SendGrid;

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

        $this->sendgrid();
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
            'link' => route('password-reset.edit', [
                'token' => sha1(sha1($user->email))
            ])
        ];

        return view('auth.passwords.message', $data);


        /**
         * return redirect()->route('auth.passwords.email')->with([
         * 'success' => true,
         * 'message' => 'Solicitação realizada com sucesso, para proseguir olhe seu email'
         * ]);
         * */

    }

    protected function sendgrid()
    {
        $from = new SendGrid\Email('Admin IF5', "admin@if5.com.br");
        $subject = "Testando api send grid";
        $to = new SendGrid\Email("Jurandi", "jurandico@gmail.com");
        $content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
        $mail = new SendGrid\Mail($from, $subject, $to, $content);

        $apiKey = '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';//getenv('SENDGRID_API_KEY');
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
        echo $response->statusCode();
        print_r($response->headers());
        echo $response->body();

        dd('END');
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
