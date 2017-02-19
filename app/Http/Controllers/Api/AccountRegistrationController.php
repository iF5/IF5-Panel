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
        dd($this->accountRegService->getAllAccounts());
    }
}
