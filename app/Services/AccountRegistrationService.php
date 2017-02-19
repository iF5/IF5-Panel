<?php

namespace App\Services;

use App\Repository\Api\AccountRepository;
use App\Services\ResultAndLogService;

class AccountRegistrationService
{
    private $account, $resultLogService;
    public function __construct()
    {
        $this->accountRepository = new AccountRepository();
        $this->resultLogService = new ResultAndLogService();
    }

    public function accountRegistration($data)
    {
        try{
            $bool = $this->accountRepository->insertAccountData($data);
            $this->resultLogService->result($bool);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Registration Error: " . $e->getMessage());
        }
    }

    public function accountUpdate($data)
    {
        try{
            $bool = $this->accountRepository->updateAccountData($data);
            $this->resultLogService->result($bool);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Update Error: " . $e->getMessage());
        }
    }

    public function findAccount($data)
    {
        try{
            $findedData = $this->accountRepository->selectAccount($data);
            $this->resultLogService->result(true, $findedData, false);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Find Error: " . $e->getMessage());
        }

    }

    public function getAllAccounts()
    {
        return $this->account->all();
    }
}
