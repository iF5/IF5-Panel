<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LoginRegistrationService;


class LoginRegistrationController extends Controller
{
    private $request, $accountRegService;
    public function __construct(Request $request)
    {
        $this->request = $request;

        //alterar antes de ir para produção
        //session(['admin' => 1]);
        //session(['client' => 1]);

        $this->loginRegService = new LoginRegistrationService();

    }

    public function registration()
    {
        $this->loginRegService->loginRegistration($this->request->all());
    }

    public function update()
    {
        $this->loginRegService->loginUpdate($this->request->all());
    }

    public function delete()
    {

    }

    public function find()
    {
        $this->loginRegService->findLogin($this->request->all());
    }

    public function show()
    {
        $this->loginRegService->getAllLogin();
    }
}
