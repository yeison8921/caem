<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FermentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla fermentaciones
         */

        $fermentaciones = [
            ['nombre' => 'Vacas de alta producción lechera (Holstein, Jersey, Ayrshire) - Peso Promedio 520kg - Producción Promedio 11,7 kg leche/día', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '84.62', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Vacas de baja producción lechera (Doble Propósito) - Peso Promedio 395 kg - Producción Promedio 3,5 kg leche/día', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '60.44', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Vacas de baja producción lechera (Doble Propósito con corte Cebuino) - Peso Promedio 380 kg - Producción Promedio 1,9 kg leche/día', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '53.05', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Toros reproductores (tipo Cebuino) - Peso Promedio 530 kg', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '57.53', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Terneros pre-destetos', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '20.14', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Terneras de reemplazo', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '30.91', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Ganado de engorde ', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '36.97', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.20000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'BUR Colombia 2015'],
            ['nombre' => 'Ganado vacuno lechero', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '87', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2019'],
            ['nombre' => 'Ganado vacuno no lechero', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '56', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2019'],
            ['nombre' => 'Búfalos', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '68', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2019'],
            ['nombre' => 'Ovejas', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '5', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2006'],
            ['nombre' => 'Cabras', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '5', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2006'],
            ['nombre' => 'Caballos', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '18', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2006'],
            ['nombre' => 'Mulas y Asnos', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '10', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2006'],
            ['nombre' => 'Cerdos', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '1', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2006'],
            ['nombre' => 'Conejos', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '0.0542', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'IPCC 2006'],
            ['nombre' => 'Pollos de engorde', 'unidad_consumo' => 'Cabezas', 'factor_emision_ch4' => '0.00009522', 'unidad_factor_emision_ch4' => 'kgCH4/cabeza', 'incertidumbre_ch4_1' => '0.30000', 'incertidumbre_ch4_2' => '0.50000', 'fuente_bibliografica_ch4' => 'Wang SY; Huang DJ'],
        ];

        DB::table('fermentaciones')->insert($fermentaciones);
    }
}
