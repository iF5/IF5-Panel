<?php

namespace App\Services;

use App\Repository\Api\LoginRepository;
use App\Services\ResultAndLogService;

class LoginRegistrationService
{
    const MD5_LENGTH = 32;
    public function __construct()
    {
        $this->loginRepository = new LoginRepository();
        $this->resultLogService = new ResultAndLogService();
    }

    public function loginRegistration($data)
    {
        try{
            $this->validateSession();

            $this->data = $data;
            $this->validateParams();

            $data['password'] = $this->hashingPassword($data['password']);
            $idLogin = $this->loginRepository->inserLoginData($data);
            if($idLogin){
                $data['idLogin'] = $idLogin;
                $this->loginRepository->insertUserData($data);
            }
            $this->resultLogService->result($idLogin);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Login Registration Error: " . $e->getMessage());
        }
    }

    private function hashingPassword($password)
    {
         if(strlen($password) < LoginRegistrationService::MD5_LENGTH){
             $password = md5($password);
         }
         return $password;
    }

    private function validateSession()
    {
        /*if(session('admin')){
            $this->sessionAdmin = session('admin');
        }elseif(session('client')){
            $this->sessionClient = session('client');
        }else{
            throw new \Exception("Session expired.");
        }*/
    }

    private function validateParams()
    {
         /*$this->client = array_key_exists('client', $this->data) ?  $this->data['client'] : 0;
         $this->provider = array_key_exists('provider', $this->data) ?  $this->data['provider'] : 0;
         if($this->provider){
             if(array_key_exists('idAllocation', $this->data)){
                 $this->idAllocation = $this->data['idAllocation'];
             }else{
                 throw new \Exception("As long as there is the provider parameter, the idAllocation parameter is required.");
             }
         }*/
    }

    public function loginUpdate($data)
    {
        try{
            $data['password'] = $this->hashingPassword($data['password']);
            $bool = $this->loginRepository->updateLoginData($data);
            $this->loginRepository->updateUserData($data);
            $this->resultLogService->result($bool);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Update Error: " . $e->getMessage());
        }
    }

    public function findLogin($data)
    {
        try{
            $findedData = $this->loginRepository->selectAccount($data);
            $this->resultLogService->result(true, $findedData, false);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Find Error: " . $e->getMessage());
        }

    }

    public function getAllLogin()
    {
        try{
            $allAccounts = $this->loginRepository->selectAllAccount();
            $this->resultLogService->result(true, $allAccounts, false);
        }catch(\Exception $e){
            $this->resultLogService->result(false, false, "Show Error: " . $e->getMessage());
        }

    }
}
