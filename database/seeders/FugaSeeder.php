<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FugaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla Fugas
         */

        $fugas = [
            ['nombre' => 'CO2', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '1', 'unidad_factor_emision_co2' => 'kgCO2e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'GWP-AR5-IPCC'],
        ];

        DB::table('fugas')->insert($fugas);
    }
}
