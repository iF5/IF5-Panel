<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AccountRegistrationService;


class AccountRegistrationController extends Controller
{
    private $request, $accountRegService;
    public function __construct(Request $request)
    {
        $this->request = $request;

        //alterar antes de ir para produção
        //session(['admin' => 1]);
        //session(['client' => 1]);

        $this->accountRegService = new AccountRegistrationService();

    }

    public function registration()
    {
        $this->accountRegService->accountRegistration($this->request->all());
    }

    public function update()
    {
        $this->accountRegService->accountUpdate($this->request->all());
    }

    public function delete()
    {

    }

    public function find()
    {
         $this->accountRegService->findAccount($this->request->all());
    }

    public function show()
    {
        $this->accountRegService->getAllAccounts();
    }
}
