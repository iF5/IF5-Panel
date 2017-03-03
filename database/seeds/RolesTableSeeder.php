<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->insert([
            [
                //'id' => 1,
                'name' => 'admin',
                'label' => 'Administrador',
                'privileges' => serialize([1, 2, 3, 4])
            ],
            [
                //'id' => 2,
                'name' => 'company',
                'label' => 'Empresa',
                'privileges' => serialize([2, 3, 4])
            ],
            [
                //'id' => 3,
                'name' => 'provider',
                'label' => 'Prestador',
                'privileges' => serialize([3, 4])
            ],
            [
                //'id' => 4,
                'name' => 'employee',
                'label' => 'Funcion&aacute;rio',
                'privileges' => serialize([4])
            ]
        ]);
    }
}
