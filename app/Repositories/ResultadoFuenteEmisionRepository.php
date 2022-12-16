<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\ResultadoFuenteEmision;
use App\Models\FactorT;
use App\Models\Gei;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * Class ResultadoFuenteEmisionRepository.
 */
class ResultadoFuenteEmisionRepository extends BaseRepository
{
    protected $array_factores;
    protected $array_geis;
    protected $array_emisiones = [
        // 'App\Models\Aislamiento' => ['co2'],
        // 'App\Models\Combustible' => ['co2', 'ch4', 'n2o'],
        // 'App\Models\Electricidad' => ['co2'],
        // 'App\Models\Emision' => ['co2'],
        // 'App\Models\Estiercol' => ['ch4', 'n2o'],
        // 'App\Models\Extintor' => ['co2'],
        // 'App\Models\Fermentacion' => ['ch4'],
        // 'App\Models\Fertilizante' => ['n2o'],
        // 'App\Models\Fuga' => ['co2'],
        // 'App\Models\Lubricante' => ['co2'],
        // 'App\Models\Papel' => ['co2'],
        // 'App\Models\Refrigerante' => ['co2'],
        // 'App\Models\Viaje' => ['co2'],
        'Combustible_solido' => ['co2', 'ch4', 'n2o'],
        'Combustible_liquido' => ['co2', 'ch4', 'n2o'],
        'Combustible_gaseoso' => ['co2', 'ch4', 'n2o'],
        'Refrigerante' => ['co2'],
        // 'Refrigerante' => ['compuestos_fluorados'],
        'Extintor' => ['co2'],
        'Lubricante' => ['co2'],
        'Fuga' => ['co2'],
        'Aislamiento' => ['co2'],
        'Embalse' => ['ch4'],
        'Mineria' => ['ch4'],
        'Industrial' => ['co2'],
        'Fermentacion' => ['ch4'],
        'Estiercol' => ['ch4', 'n2o'],
        'Residuo_organizacional' => ['ch4'],
        'Cal' => ['co2'],
        'Residuo_agropecuario' => ['ch4', 'n2o'],
        'Fertilizante' => ['n2o'],
        'Energia_electrica' => ['co2'],
    ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getFactoresT();
        $this->getGeis();
    }

    /**
     * @return string
     */
    public function model()
    {
        return ResultadoFuenteEmision::class;
    }

    /**
     * @param array $data
     *
     * @return ResultadoFuenteEmision
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): ResultadoFuenteEmision
    // {
    //     return DB::transaction(function () use ($data) {
    //         $resultado_fuente_emision = ResultadoFuenteEmision::create($data);
    //         if ($resultado_fuente_emision) {
    //             return $resultado_fuente_emision;
    //         }

    //         throw new GeneralException(__('backend_resultados_fuente_emision.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function update($request, $id_resultado_fuente_emision)
    // {
    //     $resultado_fuente_emision = ResultadoFuenteEmision::find($id_resultado_fuente_emision);
    //     $resultado_fuente_emision->update($request->all());
    //     return $resultado_fuente_emision;
    // }

    public function getFactoresT()
    {
        $factores = FactorT::all();

        foreach ($factores as $factor) {
            $this->array_factores[$factor['numero_datos']] = $factor['factor_t'];
        }
    }

    public function getGeis()
    {
        $geis = Gei::all();

        foreach ($geis as $gei) {
            $this->array_geis[$gei['gei']] = $gei['ar5pcg_gwp'];
        }
    }

    public function guardarDatosConsumos($request)
    {
        $fuentes_emision = $request->fuentes_emision;



        foreach ($fuentes_emision as $kfe => $fuente_emision) {
            foreach ($fuente_emision as $skfe => $fe) {
                $numero_datos = 0;
                $total = 0;
                foreach ($fe['resultado'] as $kd => $d) {
                    if (str_contains($kd, 'dato_')) {
                        if (!is_null($d)) {
                            $numero_datos++;
                            $total += floatval($d);
                            // $fuentes_emision[$kfe][$skfe]['resultado']['numero_datos']++;
                            // $fuentes_emision[$kfe][$skfe]['resultado']['total'] += floatval($d);
                        }
                    }
                }

                $fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] = $numero_datos;
                $fuentes_emision[$kfe][$skfe]['resultado']['total'] = $total;

                if ($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] > 1) {
                    $fuentes_emision[$kfe][$skfe]['resultado']['promedio'] = $fuentes_emision[$kfe][$skfe]['resultado']['total'] / $fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'];
                }

                $total2 = 0;
                foreach ($fe['resultado'] as $kd => $d) {
                    if (str_contains($kd, 'dato_')) {
                        if (!is_null($d)) {
                            $total2 += ($d - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']) * ($d - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']);
                        }
                    }
                }

                if ($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] > 1) {
                    $fuentes_emision[$kfe][$skfe]['resultado']['desviacion_estandar'] = sqrt(($total2 / ($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] - 1)));
                    $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos'] = 1 - (($fuentes_emision[$kfe][$skfe]['resultado']['promedio'] - (($fuentes_emision[$kfe][$skfe]['resultado']['desviacion_estandar'] * $this->array_factores[$fuentes_emision[$kfe][$skfe]['resultado']['numero_datos']]) / (sqrt($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'])))) / $fuentes_emision[$kfe][$skfe]['resultado']['promedio']);
                }

                if ($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] != 1) {
                    $fuentes_emision[$kfe][$skfe]['resultado']['factor_t'] = $this->array_factores[$fuentes_emision[$kfe][$skfe]['resultado']['numero_datos']];
                }

                $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional'] == '' ? 0 : $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional'];

                foreach ($this->array_emisiones[$fuentes_emision[$kfe][$skfe]['fuente_emision']] as $k => $e) {
                    $tipo_fuente = '';
                    $factor_emision = '';
                    $unidad_factor = '';
                    $incertidumbre_factor = '';

                    if ($fuentes_emision[$kfe][$skfe]['fuentetable_type'] == 'App\Models\Combustible' && $e != 'co2') {

                        //Establecer tipo fuente para combustible
                        $tipo_fuente = $tipo_fuente = ($fuentes_emision[$kfe][$skfe]['tipo'] == 'fuentes_moviles' ||  $tipo_fuente = $fuentes_emision[$kfe][$skfe]['tipo'] == 'transportes') ? 'fuente_movil' : 'fuente_fija';
                        $factor_emision = 'kg_' . $tipo_fuente;
                        $unidad_factor = '_' . $tipo_fuente;
                        $incertidumbre_factor = '_' . $tipo_fuente;

                        // $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e] = $fuentes_emision[$kfe][$skfe]['fuentetable']['factor_emision_' . $e . 'kg_' . $tipo_fuente];
                        // $fuentes_emision[$kfe][$skfe]['resultado']['unidad_factor_emision_' . $e] = $fe['fuentetable']['unidad_factor_emision_' . $e . '_' . $tipo_fuente];
                        // $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e] = $fe['fuentetable']['incertidumbre_' . $e . '_2_' . $tipo_fuente];
                        // $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton'] = ($fuentes_emision[$kfe][$skfe]['resultado']['total'] * $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e]) / 1000;
                        // $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq'] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton'] * $this->array_geis[$e];

                        // if ($fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton'] > 0) {
                        //     $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_emision_' . $e] = sqrt($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos'] + $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e] + $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional']);
                        // }
                        // $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_' . $e] = pow(($fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_emision_' . $e]), 2);
                    }

                    if ($fuentes_emision[$kfe][$skfe]['fuente_emision'] == 'Fermentacion' || ($fuentes_emision[$kfe][$skfe]['fuente_emision'] == 'Estiercol' && $e == 'ch4')) {
                        if ($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] > 0) {
                            $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e] = $fuentes_emision[$kfe][$skfe]['fuentetable']['factor_emision_' . $e . $factor_emision] / $fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'];
                        }
                    } else {
                        $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e] = $fuentes_emision[$kfe][$skfe]['fuentetable']['factor_emision_' . $e . $factor_emision];
                    }


                    $fuentes_emision[$kfe][$skfe]['resultado']['unidad_factor_emision_' . $e] = $fe['fuentetable']['unidad_factor_emision_' . $e . $unidad_factor];

                    $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton'] = ($fuentes_emision[$kfe][$skfe]['resultado']['total'] * $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e]) / 1000;
                    $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq'] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton'] * $this->array_geis[$e];

                    if ($fuentes_emision[$kfe][$skfe]['resultado']['total'] > 0) {
                        $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e] = $fe['fuentetable']['incertidumbre_' . $e . '_2' . $incertidumbre_factor];
                    }
                    if ($fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton'] > 0) {
                        var_dump($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos']);
                        var_dump($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e]);
                        var_dump($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional']);
                        $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_emision_' . $e] = sqrt(($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos']) + ($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e]) + ($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional']));
                    }
                    $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_' . $e] = pow(($fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_emision_' . $e]), 2);
                }

                $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono'] =  $fuentes_emision[$kfe][$skfe]['resultado']['emision_co2_ton_eq'] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_ch4_ton_eq'] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_n2o_ton_eq'] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_compuestos_fluorados_ton_eq'] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_sf6_ton_eq'] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_nf3_ton_eq'];

                if ($fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono'] > 0) {
                    $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_fuente'] = sqrt(($fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_co2'] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_ch4'] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_n2o'] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_compuestos_fluorados'] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_sf6'])) / $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono'];
                }

                if ($fuentes_emision[$kfe][$skfe]['resultado']['id'] != '') {
                    $resultado = ResultadoFuenteEmision::find($fuentes_emision[$kfe][$skfe]['resultado']['id']);
                    $resultado->update($fuentes_emision[$kfe][$skfe]['resultado']);
                } else {
                    $resultado = new ResultadoFuenteEmision();
                    $resultado->create($fuentes_emision[$kfe][$skfe]['resultado']);
                }
            }
        }
        return $fuentes_emision;
    }
}
