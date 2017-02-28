<?php

namespace App\Repository\Api;

class LoginRepository
{
    public function inserLoginData($data)
    {
        return \DB::table('IF5Panel.login')->insertGetId(
            ['idAccount' => $data['idAccount'], 'email' => $data['email'],
             'password' => $data['password'], 'createdAt' => date('Y-m-d H:i:s'),
             'updatedAt' => date('Y-m-d H:i:s')]
        );
    }

    public function insertUserData($data)
    {
        return \DB::table('IF5Panel.userData')->insert(
            ['idLogin' => $data['idLogin'], 'name' => $data['name'],
             'cpf' => $data['cpf'], 'jobRole' => $data['jobRole'],
             'department' => $data['department'],
             'phoneNumber' => $data['phoneNumber'],
             'cellPhoneNumber' => $data['cellPhoneNumber'],
             'createdAt' => date('Y-m-d H:i:s'),
             'updatedAt' => date('Y-m-d H:i:s')]
        );
    }

    public function updateLoginData($data)
    {
        return \DB::table('IF5Panel.login')
        ->where('idLogin', $data['idLogin'])
        ->update(
        ['idAccount' => $data['idAccount'], 'email' => $data['email'],
         'password' => $data['password'], 'createdAt' => date('Y-m-d H:i:s'),
         'updatedAt' => date('Y-m-d H:i:s')]
        );
    }

    public function updateUserData($data)
    {
        return \DB::table('IF5Panel.userData')
        ->where('idLogin', $data['idLogin'])
        ->update(
        ['name' => $data['name'],
         'cpf' => $data['cpf'], 'jobRole' => $data['jobRole'],
         'department' => $data['department'],
         'phoneNumber' => $data['phoneNumber'],
         'cellPhoneNumber' => $data['cellPhoneNumber'],
         'createdAt' => date('Y-m-d H:i:s'),
         'updatedAt' => date('Y-m-d H:i:s')]
        );
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
