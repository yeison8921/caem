<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FertilizanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla fertilizantes
         */

        $fertilizantes = [
            ['nombre' => 'Uso de fertilizantes sintéticos (climas húmedos)', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.025142857', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.10000', 'incertidumbre_no2_2' => '3.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Uso de fertilizantes orgánicos y residuos agrícolas (climas húmedos)', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.009428571', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.10000', 'incertidumbre_no2_2' => '3.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Uso de fertilizantes minerales, abonos orgánicos y residuos agrícolas (climas secos)', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.015714286', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.10000', 'incertidumbre_no2_2' => '3.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Fertilización directa de vacunos, aves de corral y porcinos (climas húmedos)', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.094285714', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.35000', 'incertidumbre_no2_2' => '3.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Fertilización directa de vacunos, aves de corral y porcinos (climas secos)', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.031428571', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.33330', 'incertidumbre_no2_2' => '3.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Fertilización directa de ovinos y otros animales', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.015714286', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.33330', 'incertidumbre_no2_2' => '3.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Uso de fertilizantes aplicados en arrozales inundados', 'unidad_consumo' => 'kg N2', 'factor_emision_no2' => '0.004714286', 'unidad_factor_emision_no2' => 'kgN2O/kgN2', 'incertidumbre_no2_1' => '0.01000', 'incertidumbre_no2_2' => '2.00000', 'fuente_bibliografica_no2' => 'IPCC 2019'],
            ['nombre' => 'Caliza cálcica aplicada (CaCO3)', 'unidad_consumo' => 'kg Cal', 'factor_emision_no2' => '0.44', 'unidad_factor_emision_no2' => 'kgCO2eq/kg cal', 'incertidumbre_no2_1' => '0.01000', 'incertidumbre_no2_2' => '0.50000', 'fuente_bibliografica_no2' => 'IPCC 2006'],
            ['nombre' => 'Cal Dolomita Aplicada (CaMg(CO3)2)', 'unidad_consumo' => 'kg Cal', 'factor_emision_no2' => '0.476666667', 'unidad_factor_emision_no2' => 'kgCO2eq/kg cal', 'incertidumbre_no2_1' => '0.01000', 'incertidumbre_no2_2' => '0.50000', 'fuente_bibliografica_no2' => 'IPCC 2006'],
            ['nombre' => 'Fertilización con Urea (CO(NH2)2)', 'unidad_consumo' => 'kg urea', 'factor_emision_no2' => '0.733333333', 'unidad_factor_emision_no2' => 'kgCO2eq/kg urea', 'incertidumbre_no2_1' => '0.01000', 'incertidumbre_no2_2' => '0.50000', 'fuente_bibliografica_no2' => 'IPCC 2006'],
        ];

        DB::table('fertilizantes')->insert($fertilizantes);
    }
}
