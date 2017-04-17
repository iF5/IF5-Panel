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
            'phone' => '11 0000-0000',
            'cellPhone' => '11 90000-0000',
            'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            'updatedAt' => (new \DateTime())->format('Y-m-d H:i:s')
            //'isAllPrivileges' => true
        ]);
    }
}
