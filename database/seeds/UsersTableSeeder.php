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
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@if5.com.br';
        $user->password = bcrypt('123456');
        $user->roleId = 1;
        $user->isAllPrivileges = 1;
        //Save
        $user->save();
    }
}
