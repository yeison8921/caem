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
            ['nombre' => 'SF6', 'unidad_consumo' => 'kg', 'factor_emision_sf6' => '23500', 'unidad_factor_emision_sf6' => 'kgsf6e/kg', 'incertidumbre_sf6_1' => '0.01000', 'incertidumbre_sf6_2' => '0.50000', 'fuente_bibliografica_sf6' => 'GWP-AR5-IPCC', 'unidad_consumo_2' => 'kg', 'factor_emision_sf6_2' => '22800', 'unidad_factor_emision_sf6_2' => 'kgsf6e/kg', 'incertidumbre_sf6_1_2' => '0.01000', 'incertidumbre_sf6_2_2' => '0.50000', 'fuente_bibliografica_sf6_2' => 'GWP-AR4-IPCC'],
        ];

        DB::table('aislamientos')->insert($aislamientos);
    }
}
