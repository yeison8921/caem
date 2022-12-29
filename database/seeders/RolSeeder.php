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
            ['id' => 1, 'nombre' => 'Admin'],
            ['id' => 2, 'nombre' => 'Empresario'],
            ['id' => 3, 'nombre' => 'Lider Convenio'],
            ['id' => 4, 'nombre' => 'Lider Caem'],
        ];

        DB::table('roles')->insertOrIgnore($roles);
    }
}
