<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AislamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla aislamientos
         */

        $aislamientos = [
            ['nombre' => 'SF6', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '23500', 'unidad_factor_emision_co2' => 'kgCO2e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'GWP-AR5-IPCC', 'unidad_consumo_2' => 'kg', 'factor_emision_co2_2' => '22800', 'unidad_factor_emision_co2_2' => 'kgCO2e/kg', 'incertidumbre_co2_1_2' => '0.01000', 'incertidumbre_co2_2_2' => '0.50000', 'fuente_bibliografica_co2_2' => 'GWP-AR4-IPCC'],
        ];

        DB::table('aislamientos')->insert($aislamientos);
    }
}
