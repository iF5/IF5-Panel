<?php

use Illuminate\Database\Seeder;

use App\User;

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
            'isAllPrivileges' => true
        ]);
    }
}
