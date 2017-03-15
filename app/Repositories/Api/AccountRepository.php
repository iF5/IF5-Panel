<?php

namespace App\Repositories\Api;

class AccountRepository
{
    public function insertAccountData($data)
    {
        return \DB::table('IF5Panel.account')->insertGetId(
            ['name' => $data['name'], 'cnpj' => $data['cnpj'],
            'createdAt' => date('Y-m-d H:i:s'), 'updatedAt' => date('Y-m-d H:i:s')]
        );
    }

    public function insertAccountProfile($idAccount, $idAccountType)
    {
        return \DB::table('IF5Panel.accountProfile')->insert(
            ['idAccount' => $idAccount, 'idAccountType' => $idAccountType]
        );
    }

    public function insertProviderAllocation($idAccount, $idClient)
    {
        return \DB::table('IF5Panel.providerAllocation')->insert(
            ['idProvider' => $idAccount, 'idClient' => $idClient]
        );
    }

    public function updateAccountData($data)
    {
        return \DB::table('IF5Panel.account')
        ->where('idAccount', $data['id'])
        ->update(
        ['name' => $data['name'], 'cnpj' => $data['cnpj'],
         'updatedAt' => date('Y-m-d H:i:s')]);
    }

    public function selectAccount($data)
    {
        $where = "";
        if(array_key_exists('name', $data) and $data['name']){
             $where = "name like '%" . $data['name']. "%';";
        }
        if(array_key_exists('cnpj', $data) and $data['cnpj']){
            $where = "cnpj = '" . $data['cnpj']. "';";
        }

        $query = "SELECT * FROM IF5Panel.account WHERE " . $where;
        return \DB::select($query);
    }

    public function selectAllAccount()
    {
        $query = "SELECT * FROM IF5Panel.account";
        return \DB::select($query);
    }
}
