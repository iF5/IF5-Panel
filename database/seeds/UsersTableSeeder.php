<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@if5.com.br',
            'password' => bcrypt('123456'),
            'role' => 'admin',
            'cpf' => '000.000.000-00',
            'jobRole' => 'gerente',
            'department' => 'TI',
            'phoneNumber' => '0000-0000',
            'cellPhoneNumber' => '00000-0000',
            //'isAllPrivileges' => true
        ]);
    }
}
