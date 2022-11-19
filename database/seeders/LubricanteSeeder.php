<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LubricanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla lubricantes
         */

        $lubricantes = [
            ['nombre' => 'Aceites lubricantes', 'unidad_consumo' => 'gal', 'factor_emision_co2' => '1.562310288', 'unidad_factor_emision_co2' => 'kg CO2/galón', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'IPCC 2006'],
            ['nombre' => 'Grasa Lubricante', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '0.5896', 'unidad_factor_emision_co2' => 'kg CO2/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'IPCC 2006'],
        ];

        DB::table('lubricantes')->insert($lubricantes);
    }
}
