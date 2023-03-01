<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla roles
         */

        $roles = [
            ['id' => 1, 'nombre' => 'Administrador'],
            ['id' => 2, 'nombre' => 'Empresario'],
            ['id' => 3, 'nombre' => 'Lider Caem'],
            ['id' => 4, 'nombre' => 'Lider Convenio'],
        ];

        DB::table('roles')->insertOrIgnore($roles);
    }
}
