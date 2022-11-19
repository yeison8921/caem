<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeder para tabla Papeles
         */

        $papeles = [
            ['nombre' => 'Papel bond blanco', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '1.05', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'Silva D., Raymundo A., Oliveira J., Ometto A., 2015. Life cycle assessment of offset paper production in Brazil: hotspots and cleaner production alternatives. Journal of cleaner Production. (93) 222-233'],
            ['nombre' => 'Papel reciclado', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '0.81', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'European reference Lifecycle Database:  Graphic Paper; technology mix; production mix, at plant; 79% primary fibre, 21% recycled fibre'],
            ['nombre' => 'Papel mate de revista', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '0.83', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'Leon J., Aliaga C., Boulougouris G., Hortal M., Marti J., 2015. Quantifying GHG emissions savings potential in magazine paper production: a case study on supercalendered and light-weight coated papers. Journal of Cleaner Production. (103) 301-308'],
            ['nombre' => 'Papel brillante de revista', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '1.39', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'Leon J., Aliaga C., Boulougouris G., Hortal M., Marti J., 2015. Quantifying GHG emissions savings potential in magazine paper production: a case study on supercalendered and light-weight coated papers. Journal of Cleaner Production. (103) 301-308'],
            ['nombre' => 'Polietileno de alta densidad ', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '2.87', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'European reference Lifecycle Database Polyethylene high density granulate (PE-HD);production mix, at plant'],
            ['nombre' => 'Polietileno de baja densidad ', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '2.08', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'European reference Lifecycle Database: Polyethylene low density granulate (PE-LD);production mix, at plant'],
            ['nombre' => 'Polipropileno ', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '2.89', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'European reference Lifecycle Database:  Polypropylene granulate (PP); production mix, at plant'],
            ['nombre' => 'Aluminio primario ', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '11.1', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'Center for environmental assessment of product and material systems (CPM LCA Database): primary aluminium production'],
            ['nombre' => 'Aluminio reciclado', 'unidad_consumo' => 'kg', 'factor_emision_co2' => '2.33', 'unidad_factor_emision_co2' => 'kgCO2 e/kg', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.50000', 'fuente_bibliografica_co2' => 'European reference Lifecycle Database: Aluminium extrusión profile; primary production; production mix, at plant; aluminium semi-finished extrusión product, including primary production, transformation and recycling'],
            ['nombre' => 'Agua potable', 'unidad_consumo' => 'm3', 'factor_emision_co2' => '0.1', 'unidad_factor_emision_co2' => 'kgCO2 e/m3', 'incertidumbre_co2_1' => '0.01000', 'incertidumbre_co2_2' => '0.16000', 'fuente_bibliografica_co2' => 'EAB, 2014. Inventario de emisiones de GEI Acueducto 2014'],
        ];

        DB::table('papeles')->insert($papeles);
    }
}
