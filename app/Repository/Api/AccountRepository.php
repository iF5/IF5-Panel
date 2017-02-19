<?php

namespace App\Repository\Api;

class AccountRepository
{
    public function insertAccountData($data)
    {
        return \DB::insert(
                    "INSERT INTO " . " IF5Panel.account " .
                    "(name, cnpj, createdAt, updatedAt) VALUES(?, ?, current_timestamp, current_timestamp)",
                    [$data['name'], $data['cnpj']]
                   );
    }

    public function updateAccountData($data)
    {
        return \DB::table('IF5Panel.account')
                        ->where('idAccount', $data['id'])
                        ->update(['name' => $data['name'], 'cnpj' => $data['cnpj'], 'updatedAt' => date('Y-m-d H:i:s')]);
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
}
