<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactorTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla factores t
         */

        $factores = [

            ['numero_datos' => 0, 'factor_t' => 0],
            ['numero_datos' => 2, 'factor_t' => 12.71],
            ['numero_datos' => 3, 'factor_t' => 4.3],
            ['numero_datos' => 4, 'factor_t' => 3.18],
            ['numero_datos' => 5, 'factor_t' => 2.78],
            ['numero_datos' => 6, 'factor_t' => 2.57],
            ['numero_datos' => 7, 'factor_t' => 2.45],
            ['numero_datos' => 8, 'factor_t' => 2.36],
            ['numero_datos' => 9, 'factor_t' => 2.31],
            ['numero_datos' => 10, 'factor_t' => 2.26],
            ['numero_datos' => 11, 'factor_t' => 2.23],
            ['numero_datos' => 12, 'factor_t' => 2.2],
        ];

        DB::table('factores_t')->insert($factores);
    }
}
