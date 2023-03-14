<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla viajes
         */

        $viajes = [
            ['nombre' => 'Bogotá - Armenia - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '51.8', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Barrancabermeja - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '92.6', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Barranquilla - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '165', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Bucaramanga - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '97.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Buenaventura - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '76.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Cali - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '92.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Cartagena - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '156.2', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Cúcuta - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '117.2', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Florencia - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '79.8', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Ibagué - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '33.8', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Leticia - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '214.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Manizales - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '35.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Medellín - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '77.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Mitú - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '218.2', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Montería - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '125.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Neiva - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '60.6', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Pasto - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '171.6', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Pereira - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '67.6', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Popayán - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '72.2', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Puerto Asís - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '102', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Puerto Carreño - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '251.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Puerto Inírida - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '240.8', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Riohacha - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '192', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Santa Marta - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '170.4', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Valledupar - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '154.6', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Villavicencio - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '23.2', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Bogotá - Yopal - Bogotá', 'unidad_consumo' => 'pasajero', 'factor_emision_co2' => '49.6', 'unidad_factor_emision_co2' => 'kgCO2 e/Viaje', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'ICAO, 2016', 'tipo' => 'pasajero'],
            ['nombre' => 'Transporte aéreo de carga', 'unidad_consumo' => 't*km', 'factor_emision_co2' => '1.05', 'unidad_factor_emision_co2' => 'kg CO2 e/ t*km', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'USDA-LCI (ICAO 2003)', 'tipo' => 'carga'],
            ['nombre' => 'Transporte marítimo de carga', 'unidad_consumo' => 't*km', 'factor_emision_co2' => '0.0144', 'unidad_factor_emision_co2' => 'kg CO2 e/ t*km', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'USDA-LCI. 2006 (ARGO 2001)', 'tipo' => 'carga'],
            ['nombre' => 'Transporte terrestre de carga', 'unidad_consumo' => 't*km', 'factor_emision_co2' => '0.0782', 'unidad_factor_emision_co2' => 'kg CO2 e/ t*km', 'incertidumbre_co2_1' => '0.05000', 'incertidumbre_co2_2' => '0.05000', 'fuente_bibliografica_co2' => 'USDA-LCI- (EPA 2010)', 'tipo' => 'carga'],
            ['nombre' => 'Otros viajes aéreos de pasajeros', 'unidad_consumo' => 'tCO2/año', 'factor_emision_co2' => '1', 'unidad_factor_emision_co2' => 'tCO2/año', 'incertidumbre_co2_1' => '0.071', 'incertidumbre_co2_2' => '0.071', 'fuente_bibliografica_co2' => 'FUENTE', 'tipo' => 'aereo'],
        ];

        DB::table('viajes')->insert($viajes);
    }
}
