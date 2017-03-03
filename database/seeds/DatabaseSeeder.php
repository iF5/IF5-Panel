<?php

use Illuminate\Database\Seeder;


/**
 * Class DatabaseSeeder
 *
 * Caso falhar use o comando : composer dump-autoload
 */

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
