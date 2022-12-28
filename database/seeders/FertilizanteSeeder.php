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
         * Seeder para tabla Fertilizantes
         */

        $Fertilizantes = [
            ['nombre' => 'Uso de Fertilizantes sintéticos (climas húmedos)', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.025142857', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.10000', 'incertidumbre_n2o_2' => '3.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Uso de Fertilizantes orgánicos y residuos agrícolas (climas húmedos)', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.009428571', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.10000', 'incertidumbre_n2o_2' => '3.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Uso de Fertilizantes minerales, abonos orgánicos y residuos agrícolas (climas secos)', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.015714286', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.10000', 'incertidumbre_n2o_2' => '3.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Fertilización directa de vacunos, aves de corral y porcinos (climas húmedos)', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.094285714', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.35000', 'incertidumbre_n2o_2' => '3.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Fertilización directa de vacunos, aves de corral y porcinos (climas secos)', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.031428571', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.33330', 'incertidumbre_n2o_2' => '3.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Fertilización directa de ovinos y otros animales', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.015714286', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.33330', 'incertidumbre_n2o_2' => '3.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Uso de Fertilizantes aplicados en arrozales inundados', 'unidad_consumo' => 'kg N2', 'factor_emision_co2' => null, 'unidad_factor_emision_co2' => null, 'incertidumbre_co2_1' => null, 'incertidumbre_co2_2' => null, 'fuente_bibliografica_co2' => null, 'factor_emision_n2o' => '0.004714286', 'unidad_factor_emision_n2o' => 'kgN2O/kgN2', 'incertidumbre_n2o_1' => '0.01000', 'incertidumbre_n2o_2' => '2.00000', 'fuente_bibliografica_n2o' => 'IPCC 2019', 'tipo' => 'Fertilizante'],
            ['nombre' => 'Caliza cálcica aplicada (CaCO3)', 'unidad_consumo' => 'kg Cal', 'factor_emision_co2' => '0.44', 'unidad_factor_emision_co2' => 'kgCO2eq/kg Cal', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'IPCC 2006', 'factor_emision_n2o' => null, 'unidad_factor_emision_n2o' => null, 'incertidumbre_n2o_1' => null, 'incertidumbre_n2o_2' => null, 'fuente_bibliografica_n2o' => null, 'tipo' => 'Cal'],
            ['nombre' => 'Cal Dolomita Aplicada (CaMg(CO3)2)', 'unidad_consumo' => 'kg Cal', 'factor_emision_co2' => '0.476666667', 'unidad_factor_emision_co2' => 'kgCO2eq/kg Cal', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'IPCC 2006', 'factor_emision_n2o' => null, 'unidad_factor_emision_n2o' => null, 'incertidumbre_n2o_1' => null, 'incertidumbre_n2o_2' => null, 'fuente_bibliografica_n2o' => null, 'tipo' => 'Cal'],
            ['nombre' => 'Fertilización con Urea (CO(NH2)2)', 'unidad_consumo' => 'kg urea', 'factor_emision_co2' => '0.733333333', 'unidad_factor_emision_co2' => 'kgCO2eq/kg urea', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'IPCC 2006', 'factor_emision_n2o' => null, 'unidad_factor_emision_n2o' => null, 'incertidumbre_n2o_1' => null, 'incertidumbre_n2o_2' => null, 'fuente_bibliografica_n2o' => null, 'tipo' => 'Cal'],
        ];

        DB::table('fertilizantes')->insert($Fertilizantes);
    }
}
