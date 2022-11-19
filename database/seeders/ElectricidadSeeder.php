<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElectricidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla Electricidad
         */

        $electricidades = [
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión XM-UPME 2020)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.203', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'XM, 2021'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2019)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.166', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2020'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2018)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.128', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2019'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2017)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.11', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2018'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2016)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.2096', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2017'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2015)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.199', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2016'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2014)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.19', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2015'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2013)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.2', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2014'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2012)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.15', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2013'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2011)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.22', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2012'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2010)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.19', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2011'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-FECOC 2009)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.19', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME, 2010'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión Informe EIA 2013)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.153', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'EIA'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión Informe EIA 2011)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.136', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'EIA'],
            ['nombre' => 'Energía eléctrica adquirida (Factor emisión UPME-MDL 2008)', 'unidad_consumo' => 'KWh', 'factor_emision_co2' => '0.2904', 'unidad_factor_emision_co2' => 'kgCO2 e/KWh', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.10000', 'fuente_bibliografica_co2' => 'UPME'],
        ];

        DB::table('electricidades')->insert($electricidades);
    }
}
