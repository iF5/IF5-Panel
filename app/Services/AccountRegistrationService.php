<?php

namespace App\Services;

use App\Repository\Api\AccountRepository;
use App\Services\ResultAndLogService;

class AccountRegistrationService
{
    private $account, $resultLogService, $client,
             $provider, $data, $idAllocation, $sessionAdmin, $sessionClient;
    const CLIENT = 2;
    const PROVIDER = 3;
    public function __construct()
    {
        $this->accountRepository = new AccountRepository();
        $this->resultLogService = new ResultAndLogService();
    }

    public function accountRegistration($data)
    {
        try{
            $this->validateSession();

            $this->data = $data;
            $this->validateParams();

            $idAccount = $this->accountRepository->insertAccountData($data);
            if($idAccount){
                $this->accountProfileRegistration($data, $idAccount);
            }
            $this->resultLogService->result($idAccount);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Account Registration Error: " . $e->getMessage());
        }
    }

    private function validateSession()
    {
        if(session('admin')){
            $this->sessionAdmin = session('admin');
        }elseif(session('client')){
            $this->sessionClient = session('client');
        }else{
            throw new \Exception("Session expired.");
        }
    }

    private function validateParams()
    {
         $this->client = array_key_exists('client', $this->data) ?  $this->data['client'] : 0;
         $this->provider = array_key_exists('provider', $this->data) ?  $this->data['provider'] : 0;
         if($this->provider){
             if(array_key_exists('idAllocation', $this->data)){
                 $this->idAllocation = $this->data['idAllocation'];
             }else{
                 throw new \Exception("As long as there is the provider parameter, the idAllocation parameter is required.");
             }
         }
    }

    private function accountProfileRegistration($data, $idAccount)
    {
        if($this->sessionAdmin){
           if($this->client == "1"){
               $this->accountRepository->insertAccountProfile($idAccount, AccountRegistrationService::CLIENT);
           }elseif($this->provider == "1"){
               $this->profileProviderRegistration($idAccount);
           }
       }elseif($this->sessionClient){
           if($this->provider == "1"){
               $this->profileProviderRegistration($idAccount);
           }
       }
    }

    private function profileProviderRegistration($idAccount)
    {
        $arrayAccountAllocation = $this->buildArrayAllocation();

        $this->accountRepository->insertAccountProfile($idAccount, AccountRegistrationService::PROVIDER);
        foreach($arrayAccountAllocation as $idClient){
             $this->accountRepository->insertProviderAllocation($idAccount, $idClient);
        }
    }

    private function buildArrayAllocation()
    {
        return explode(",", $this->idAllocation);
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
        try{
            $allAccounts = $this->accountRepository->selectAllAccount();
            $this->resultLogService->result(true, $allAccounts, false);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Show Error: " . $e->getMessage());
        }

    }
}
