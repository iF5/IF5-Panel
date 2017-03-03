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

    public function selectLogin($data)
    {
        $where = "";
        if(array_key_exists('email', $data) and $data['email']){
             $where = "email like '%" . $data['email']. "%';";
        }
        if(array_key_exists('idLogin', $data) and $data['idLogin']){
            $where = "idLogin = '" . $data['idLogin']. "';";
        }

        $query = "SELECT * FROM IF5Panel.login WHERE " . $where;
        return \DB::select($query);
    }

    public function selectAllLogin()
    {
        $query = "SELECT * FROM IF5Panel.login";
        return \DB::select($query);
    }
}
