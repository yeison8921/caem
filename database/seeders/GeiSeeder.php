<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeiSeeder extends Seeder
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

        $geis = [
            ['gei' => 'co2', 'ar5pcg_gwp' => 1, 'ar4pcg_gwp' => 1, 'srpcg_gwp' => 1],
            ['gei' => 'ch4', 'ar5pcg_gwp' => 28, 'ar4pcg_gwp' => 25, 'srpcg_gwp' => 21],
            ['gei' => 'n2o', 'ar5pcg_gwp' => 265, 'ar4pcg_gwp' => 298, 'srpcg_gwp' => 310],
            ['gei' => 'sf6', 'ar5pcg_gwp' => 23500, 'ar4pcg_gwp' => 22800, 'srpcg_gwp' => 0],
            ['gei' => 'nf3', 'ar5pcg_gwp' => 16100, 'ar4pcg_gwp' => 17200, 'srpcg_gwp' => 0],
        ];

        DB::table('geis')->insert($geis);
    }
}
