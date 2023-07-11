<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\Combustible;
use App\Models\ResultadoFuenteEmision;
use App\Models\InformacionEmpresa;
use App\Models\FactorT;
use App\Models\FuenteEmision;
use App\Models\Gei;
use App\Models\PorcentajeCombustible;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * Class ResultadoFuenteEmisionRepository.
 */
class ResultadoFuenteEmisionRepository extends BaseRepository
{
    protected $array_porcentajes;
    protected $array_factores;
    protected $array_biogenicos;
    protected $array_ar = ['_ar5', '_ar6'];
    protected $array_combustibles_porcentaje_corporativo = [26, 37, 27, 38];
    protected $json_geis;
    protected $array_emisiones = [
        'Combustible_solido' => ['co2', 'ch4', 'n2o'],
        'Combustible_liquido' => ['co2', 'ch4', 'n2o'],
        'Combustible_gaseoso' => ['co2', 'ch4', 'n2o'],
        'Refrigerante' => ['compuestos_fluorados'],
        'Extintor' => ['co2'],
        'Lubricante' => ['co2'],
        'Fuga' => ['co2'],
        'Aislamiento' => ['sf6'],
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
        'Transporte_carga' => ['co2'],
        'Transporte_pasajeros' => ['co2'],
        'Transporte_aereo' => ['co2'],
        'Materia_prima' => ['co2'],
        'Servicio' => ['co2'],
        'Fin' => ['co2'],
        'Equipo' => ['co2'],
        'Otro' => ['co2'],
        'Residuo' => ['ch4'],
        'Trasversal' => ['co2', 'ch4', 'n2o'],
        'Producto' => ['co2'],
        'Activo' => ['co2'],
        'Inversion' => ['co2'],
        'Otro' => ['co2'],
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getPorcentajes();
        $this->getFactoresT();
        $this->getGeis();
        $this->getBiogenicos();
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

    public function getPorcentajes()
    {
        $porcentajes = PorcentajeCombustible::get(['nombre', 'valor']);
        foreach ($porcentajes as $key => $v) {
            $this->array_porcentajes[$v->nombre] = $v->valor;
            $this->array_porcentajes[$v->nombre] = $v->valor;
        }
    }

    public function getBiogenicos()
    {
        $this->array_biogenicos = Combustible::where('biogenico', 1)->pluck('nombre')->toArray();
    }

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

        $this->json_geis = new \stdClass;
        $ar5 = new \stdClass;
        $ar6 = new \stdClass;

        foreach ($geis as $k => $gei) {
            $nombre = $gei['gei'];
            $ar5->$nombre = $gei['ar5pcg_gwp'];
            $ar6->$nombre = $gei['ar6pcg_gwp'];
        }
        $this->json_geis->_ar5 = $ar5;
        $this->json_geis->_ar6 = $ar6;
    }

    public function guardarDatosConsumos($request)
    {
        $fuentes_emision = $request->fuentes_emision;

        foreach ($this->array_ar as $ar) {
            foreach ($fuentes_emision as $kfe => $fuente_emision) {
                foreach ($fuente_emision as $skfe => $fe) {
                    $numero_datos = 0;
                    $total = 0;
                    foreach ($fe['resultado'] as $kd => $d) {
                        if (str_contains($kd, 'dato_')) {
                            if (!is_null($d)) {
                                $numero_datos++;
                                if (in_array($fuentes_emision[$kfe][$skfe]['fuentetable_id'], $this->array_combustibles_porcentaje_corporativo)) {
                                    $total += floatval(($d * $this->array_porcentajes['corporativo']) / 100);
                                } else if (str_contains($fuentes_emision[$kfe][$skfe]['tipo'], 'biogenico')) {
                                    $total += floatval(($d * $this->array_porcentajes['biogenico']) / 100);
                                } else {
                                    $total += floatval($d);
                                }
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
                                if (in_array($fuentes_emision[$kfe][$skfe]['fuentetable_id'], $this->array_combustibles_porcentaje_corporativo)) {
                                    $total2 += (floatval(($d * $this->array_porcentajes['corporativo']) / 100) - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']) * (floatval(($d * $this->array_porcentajes['corporativo']) / 100) - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']);
                                } else if (str_contains($fuentes_emision[$kfe][$skfe]['tipo'], 'biogenico')) {
                                    $total2 += (floatval(($d * $this->array_porcentajes['biogenico']) / 100) - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']) * (floatval(($d * $this->array_porcentajes['biogenico']) / 100) - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']);
                                } else {
                                    $total2 += ($d - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']) * ($d - $fuentes_emision[$kfe][$skfe]['resultado']['promedio']);
                                }
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
                        $biogenico = '';

                        if (($fuentes_emision[$kfe][$skfe]['fuentetable_type'] == 'App\Models\Combustible' || $fuentes_emision[$kfe][$skfe]['fuentetable_type'] == 'App\Models\Trasversal') && $e != 'co2') {
                            //Establecer tipo fuente para combustible
                            $tipo_fuente = $tipo_fuente = ($fuentes_emision[$kfe][$skfe]['tipo'] == 'fuentes_moviles' || $tipo_fuente = $fuentes_emision[$kfe][$skfe]['tipo'] == 'transportes') ? 'fuente_movil' : 'fuente_fija';
                            $factor_emision = 'kg_' . $tipo_fuente;
                            $unidad_factor = '_' . $tipo_fuente;
                            $incertidumbre_factor = '_' . $tipo_fuente;
                        }

                        if ($fuentes_emision[$kfe][$skfe]['fuentetable_type'] == 'App\Models\Combustible' && $e == 'co2') {
                            if (in_array($fuentes_emision[$kfe][$skfe]['fuentetable']['nombre'], $this->array_biogenicos)) {
                                $biogenico = '_biogenico';
                            }
                        }

                        if ($fuentes_emision[$kfe][$skfe]['fuente_emision'] == 'Fermentacion' || ($fuentes_emision[$kfe][$skfe]['fuente_emision'] == 'Estiercol' && $e == 'ch4')) {
                            if ($fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'] > 0) {
                                $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e . $ar] = $fuentes_emision[$kfe][$skfe]['fuentetable']['factor_emision_' . $e . $factor_emision] / $fuentes_emision[$kfe][$skfe]['resultado']['numero_datos'];
                            }
                        } else {
                            if ($e == 'sf6') {
                                $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e . $biogenico . $ar] = $fuentes_emision[$kfe][$skfe]['fuentetable']['factor_emision_' . $e . $factor_emision] / $this->json_geis->$ar->$e;;
                            } else {
                                if (str_contains($fuentes_emision[$kfe][$skfe]['tipo'], 'biogenico') && $e != 'co2') {
                                    $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e . $biogenico . $ar] = 0;
                                } else {
                                    $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e . $biogenico . $ar] = $fuentes_emision[$kfe][$skfe]['fuentetable']['factor_emision_' . $e . $factor_emision];
                                }
                            }
                        }

                        $fuentes_emision[$kfe][$skfe]['resultado']['unidad_factor_emision_' . $e . $ar] = $fe['fuentetable']['unidad_factor_emision_' . $e . $unidad_factor];
                        $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton' . $biogenico . $ar] = ($fuentes_emision[$kfe][$skfe]['resultado']['total'] * $fuentes_emision[$kfe][$skfe]['resultado']['factor_emision_' . $e . $biogenico . $ar]) / 1000;

                        if ($fuentes_emision[$kfe][$skfe]['tipo'] == 'transportes_carga_pasajeros') {
                            if ($fuentes_emision[$kfe][$skfe]['fuentetable']['tipo'] == 'aereo') {
                                $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq' . $biogenico . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['dato_1'] / 1000;
                            } else {
                                $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq' . $biogenico . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton' . $biogenico . $ar] * $this->json_geis->$ar->$e;
                            }
                        } else {
                            $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq' . $biogenico . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton' . $biogenico . $ar] * $this->json_geis->$ar->$e;
                        }


                        if ($fuentes_emision[$kfe][$skfe]['resultado']['total'] > 0) {
                            $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e . $biogenico . $ar] = $fe['fuentetable']['incertidumbre_' . $e . '_2' . $incertidumbre_factor];
                        }
                        if ($fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton' . $biogenico . $ar] > 0) {
                            $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_emision_' . $e . $biogenico . $ar] = sqrt(($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_datos']) + ($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e . $biogenico . $ar] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_factor_emision_' . $e . $biogenico . $ar]) + ($fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional'] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_sistematica_adicional']));
                        }
                        $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_' . $e . $biogenico . $ar] = pow(($fuentes_emision[$kfe][$skfe]['resultado']['emision_' . $e . '_ton_eq' . $biogenico . $ar] * $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_emision_' . $e . $biogenico . $ar]), 2);

                        if ($biogenico == '') {
                            if ($fuentes_emision[$kfe][$skfe]['tipo'] == 'transportes_carga_pasajeros') {
                                if ($fuentes_emision[$kfe][$skfe]['fuentetable']['tipo'] == 'aereo') {
                                    $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['dato_1'] / 1000;
                                } else {
                                    $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_co2_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_ch4_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_n2o_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_compuestos_fluorados_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_sf6_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_nf3_ton_eq' . $ar];
                                }
                            } else {
                                $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_co2_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_ch4_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_n2o_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_compuestos_fluorados_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_sf6_ton_eq' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['emision_nf3_ton_eq' . $ar];
                            }
                        } else {
                            $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $biogenico . $ar] = $fuentes_emision[$kfe][$skfe]['resultado']['emision_co2_ton_eq' . $biogenico . $ar];
                        }

                        $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_fuente' . $biogenico . $ar] = 0;

                        if ($fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $biogenico . $ar] > 0) {
                            if ($biogenico == '') {
                                $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_fuente' . $ar] = sqrt(($fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_co2' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_ch4' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_n2o' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_compuestos_fluorados' . $ar] + $fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_sf6' . $ar])) / $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $ar];
                            } else {
                                $fuentes_emision[$kfe][$skfe]['resultado']['incertidumbre_fuente' . $biogenico . $ar] = sqrt(($fuentes_emision[$kfe][$skfe]['resultado']['columna_auxiliar_co2' . $biogenico . $ar])) / $fuentes_emision[$kfe][$skfe]['resultado']['huella_carbono' . $biogenico . $ar];
                            }
                        }
                    }

                    if ($fuentes_emision[$kfe][$skfe]['resultado']['id'] != '') {
                        $resultado = ResultadoFuenteEmision::find($fuentes_emision[$kfe][$skfe]['resultado']['id']);
                        $resultado->update($fuentes_emision[$kfe][$skfe]['resultado']);
                    } else {
                        $resultado = new ResultadoFuenteEmision();
                        $id_insertado  = $resultado->create($fuentes_emision[$kfe][$skfe]['resultado'])->id;
                        $fuentes_emision[$kfe][$skfe]['resultado']['id'] = $id_insertado;
                    }
                }
            }
        }
        return $fuentes_emision;
    }

    public function getDatosGraficas($request)
    {
        $array_resultados = [];

        $resultados = FuenteEmision::where('empresa_id', $request->empresa_id);

        $unidades_totales_producidas = InformacionEmpresa::where('empresa_id', $request->empresa_id);

        if ($request->sede_id != -1) {
            $resultados = $resultados->where('sede_id', $request->sede_id);
            $unidades_totales_producidas = $unidades_totales_producidas->where('sede_id', $request->sede_id);
        }

        if ($request->periodo != -1) {
            $resultados = $resultados->where('informacion_empresa_id', $request->periodo);
            $unidades_totales_producidas = $unidades_totales_producidas->where('id', $request->periodo);
        }

        $resultados = $resultados->whereNull('subproceso_id')->with('fuentetable', 'resultado')->get();
        $unidades_totales_producidas = $unidades_totales_producidas->get();

        $unidades_producidas = null;

        foreach ($unidades_totales_producidas as $u) {
            if (!is_null($u->unidades_producidas)) {
                $unidades_producidas += $u->unidades_producidas;
            }
        }

        if ($request->reporte == 'corporativo') {
            $request->reporte = '';
            $array_categorias = [
                ['fuentes_fijas', 'fuentes_moviles', 'emisiones'],
                ['electricidad_importada', 'energia_importada'],
                ['transportes_fuentes_moviles', 'transportes_carga_pasajeros'],
                ['bienes_productos', 'servicios'],
                ['usos', 'fines', 'activos', 'inversiones'],
                ['otros'],
                ['trasversales'],
            ];
        } else {
            $array_categorias = [
                [
                    'fuentes_fijas',
                    'fuentes_fijas_biogenico_26',
                    'fuentes_fijas_biogenico_27',
                    'fuentes_fijas_biogenico_37',
                    'fuentes_fijas_biogenico_38',
                    'fuentes_moviles',
                    'fuentes_moviles_biogenico_26',
                    'fuentes_moviles_biogenico_27',
                    'fuentes_moviles_biogenico_37',
                    'fuentes_moviles_biogenico_38',
                ],
                [
                    'energia_importada',
                    'energia_importada_biogenico_26',
                    'energia_importada_biogenico_27',
                    'energia_importada_biogenico_37',
                    'energia_importada_biogenico_38',
                ],
                [
                    'transportes_fuentes_moviles',
                    'transportes_fuentes_moviles_biogenico_26',
                    'transportes_fuentes_moviles_biogenico_27',
                    'transportes_fuentes_moviles_biogenico_37',
                    'transportes_fuentes_moviles_biogenico_38',
                ],
            ];
        }

        $total_huella_carbono = 0;

        $array_labels_directa = ['Directas', 'Indirectas'];
        $array_totales_directa = [0, 0];
        $array_colores_directa = [];

        $array_labels_fuente = [
            'Consumo de combustibles solidos',
            'Consumo de combustibles líquidos',
            'Consumo de combustibles gaseosos',
            'Consumo de refrigerantes y espumantes',
            'Uso de extintores',
            'Consumo de lubricantes',
            'Fugas de CO2 en proceso',
            'Consumo de aislante eléctrico',
            'Uso de embalses o represamientos de agua',
            'Procesos industriales',
            'Procesos de minería',
            'Procesos agricolas (ganadería - fermentación entérica)',
            'Procesos agrícolas (manejo de estiércol)',
            'Proceso agrícolas (manejo de residuos agropecuarios)',
            'Procesos agrícolas (uso de fertilizantes)',
            'Procesos con cal',
            'Procesos de gestión de residuos',
            'Consumo de energía eléctrica',
            'Transporte de carga',
            'Transporte de pasajeros',
            'Transporte aéreo',
            'Productos',
            'Equipos',
            'Materias primas',
            'Servicios',
            'Fin de vida',
            'Activo',
            'Inversión',
            'Otros',
            'Trasversales'
        ];

        $array_labels_categoria = [
            'C1',
            'C2',
            'C3',
        ];
        $array_totales_categoria = [0, 0, 0];
        $array_colores_categoria = [];

        $array_labels_gei = [
            'CO2',
        ];
        $array_totales_gei = [0];
        $array_colores_gei = [];

        $array_totales_fuente = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $array_colores_fuente = [];

        if ($request->reporte == '') {
            array_push(
                $array_labels_categoria,
                'C4',
                'C5',
                'C6',
                'C7',
            );
            array_push($array_totales_categoria, 0, 0, 0, 0);

            array_push(
                $array_labels_gei,
                'CH4',
                'N2O',
                'COMP F',
                'SF6',
                'NF3',
            );
            array_push(
                $array_totales_gei,
                0,
                0,
                0,
                0,
                0
            );
        }

        $array_labels_tipo = [];
        $array_totales_tipo  = [];
        $array_colores_tipo = [];

        foreach ($resultados as $key => $resultado) {
            if ($resultado['resultado'] != null) {

                $total_huella_carbono += $resultado['resultado']['huella_carbono' . $request->reporte . $request->ar];

                //obtener datos directa indirecta
                //obtener datos categoría
                foreach ($array_categorias as $key => $value) {
                    if (in_array($resultado['tipo'], $value)) {
                        if ($key == 0) {
                            $array_totales_directa[0] += $resultado['resultado']['huella_carbono' . $request->reporte . $request->ar];
                        } else {
                            $array_totales_directa[1] += $resultado['resultado']['huella_carbono' . $request->reporte . $request->ar];
                        }
                    }
                    if (in_array($resultado['tipo'], $value) && $key < count($array_totales_categoria)) {
                        $array_totales_categoria[$key] += $resultado['resultado']['huella_carbono' . $request->reporte . $request->ar];
                    }
                }

                //obtener datos gei
                $array_totales_gei[0] += $resultado['resultado']['emision_co2_ton_eq' . $request->reporte . $request->ar];

                if ($request->reporte == '') {
                    $array_totales_gei[1] += $resultado['resultado']['emision_ch4_ton_eq' . $request->ar];
                    $array_totales_gei[2] += $resultado['resultado']['emision_n2o_ton_eq' . $request->ar];
                    $array_totales_gei[3] += $resultado['resultado']['emision_compuestos_fluorados_ton_eq' . $request->ar];
                    $array_totales_gei[4] += $resultado['resultado']['emision_sf6_ton_eq' . $request->ar];
                    $array_totales_gei[5] += $resultado['resultado']['emision_nf3_ton_eq' . $request->ar];
                }

                //obtener datos por fuente
                foreach ($array_labels_fuente as $key => $value) {
                    if ($resultado['fuente_emision_mostrar'] == $value) {
                        $array_totales_fuente[$key] += $resultado['resultado']['huella_carbono' . $request->reporte . $request->ar];
                    }
                }

                //obtener datos por tipo
                if ($request->reporte == '') {
                    if ($resultado['resultado']['huella_carbono' . $request->ar] > 0) {
                        array_push($array_labels_tipo, $resultado['fuentetable']['nombre'] . '<br>' . $resultado['tipo_mostrar']);
                        array_push($array_totales_tipo, $resultado['resultado']['huella_carbono' . $request->ar]);
                    }
                } else {
                    if (in_array($resultado['fuentetable']['nombre'], $this->array_biogenicos)) {
                        if ($resultado['resultado']['huella_carbono' . $request->reporte . $request->ar] > 0) {
                            array_push($array_labels_tipo, $resultado['fuentetable']['nombre'] . '<br>' . $resultado['tipo_mostrar']);
                            array_push($array_totales_tipo, $resultado['resultado']['huella_carbono' . $request->reporte . $request->ar]);
                        }
                    }
                }
            }
        }

        //obtener datos cumplimiento
        $data = InformacionEmpresa::where('empresa_id', $request->empresa_id);

        if ($request->sede_id != -1) {
            $data = $data->where('sede_id', $request->sede_id);
        }
        $data = $data->get();

        $array_cumplimiento = [];
        $array_colores_cumplimiento = [];
        $suma_pertinencia = 0;
        $suma_integralidad = 0;
        $suma_coherencia = 0;
        $suma_exactitud = 0;
        $suma_transparencia = 0;


        foreach ($data as $key => $value) {
            $suma_pertinencia += $value->efecto_invernadero + $value->sumideros;
            $suma_integralidad += $value->informacion_mensual + $value->diagrama_procesos + $value->areas_sumideros;
            $suma_coherencia += $value->informacion_centralizada + $value->soportes_consumos + $value->informacion_anio;
            $suma_exactitud += $value->estimaciones_consumos + $value->consumos_energeticos + $value->sustento_metodologico;
            $suma_transparencia += $value->compartira_reporte + $value->toma_decisiones;
        }

        $array_cumplimiento[0] = (($suma_pertinencia * 100) / 4) / count($data);
        $array_cumplimiento[1] = (($suma_integralidad * 100) / 6) / count($data);
        $array_cumplimiento[2] = (($suma_coherencia * 100) / 6) / count($data);
        $array_cumplimiento[3] = (($suma_exactitud * 100) / 6) / count($data);
        $array_cumplimiento[4] = (($suma_transparencia * 100) / 4) / count($data);


        //quitando los resultados 0 del array de fuente
        $sub_array = [];
        foreach ($array_totales_fuente as $key => $value) {
            if ($value == 0) {
                array_push($sub_array, $key);
            }
        }

        foreach (array_reverse($sub_array) as $k => $v) {
            array_splice($array_totales_fuente, $v, 1);
            array_splice($array_labels_fuente, $v, 1);
        }

        //quitando y sumando los repetidos array de tipo
        foreach (array_count_values($array_labels_tipo) as $key => $val) {
            $suma = 0;
            if ($val == 2) {
                $sub_array = array_keys($array_labels_tipo, $key);
                foreach ($sub_array as $k => $v) {
                    $suma += $array_totales_tipo[$v];
                }
                foreach (array_reverse($sub_array) as $k => $v) {
                    array_splice($array_labels_tipo, $v, 1);
                    array_splice($array_totales_tipo, $v, 1);
                }
                array_push($array_labels_tipo, $key);
                array_push($array_totales_tipo, $suma);
            }
        }

        foreach ($array_totales_directa as $key => $a) {
            array_push($array_colores_directa, sprintf('#%06X40', mt_rand(0, 0xFFFFFF)));
        }
        foreach ($array_totales_categoria as $key => $a) {
            array_push($array_colores_categoria, sprintf('#%06X40', mt_rand(0, 0xFFFFFF)));
        }

        foreach ($array_labels_gei as $key => $a) {
            array_push($array_colores_gei, sprintf('#%06X40', mt_rand(0, 0xFFFFFF)));
        }

        $total = 0;
        $array_totales_fuente_torta = [];
        foreach ($array_totales_fuente as $a) {
            $total += $a;
            array_push($array_colores_fuente, sprintf('#%06X40', mt_rand(0, 0xFFFFFF)));
        }

        foreach ($array_totales_fuente as $a) {
            array_push($array_totales_fuente_torta, (($a * 100) / $total));
        }

        foreach ($array_totales_tipo as $key => $a) {
            $array_totales_tipo[$key] = floatval($a);
            array_push($array_colores_tipo, sprintf('#%06X40', mt_rand(0, 0xFFFFFF)));
        }

        $suma = 0;
        foreach ($array_cumplimiento as $a) {
            $suma += $a;
            array_push($array_colores_cumplimiento, sprintf('#%06X40', mt_rand(0, 0xFFFFFF)));
        }


        if (is_null($unidades_producidas)) {
            $total_huella_carbono_unidad_produccion = -1;
        } else {
            $total_huella_carbono_unidad_produccion = ($total_huella_carbono / $unidades_producidas);
        }

        $array_resultados['promedio_cumplimiento'] = $suma / count($array_cumplimiento);
        $array_resultados['total_huella_carbono'] = $total_huella_carbono;
        $array_resultados['cumplimiento'] = [$array_cumplimiento, $array_colores_cumplimiento];
        $array_resultados['huella_carbono_directa_indirecta'] = [$array_labels_directa, $array_totales_directa, $array_colores_directa];
        $array_resultados['huella_carbono_categoria'] = [$array_labels_categoria, $array_totales_categoria, $array_colores_categoria];
        $array_resultados['huella_carbono_gei'] = [$array_labels_gei, $array_totales_gei, $array_colores_gei];
        $array_resultados['huella_carbono_fuente'] = [$array_labels_fuente, $array_totales_fuente, $array_colores_fuente];
        $array_resultados['huella_carbono_fuente_torta'] = [$array_labels_fuente, $array_totales_fuente_torta, $array_colores_fuente];
        $array_resultados['huella_carbono_tipo'] = [$array_labels_tipo, $array_totales_tipo, $array_colores_tipo];
        $array_resultados['total_huella_carbono_unidad_produccion'] = $total_huella_carbono_unidad_produccion;
        $array_resultados['tipo_unidad'] = $data[0]->tipo_unidad;
        $array_resultados['esta_aprobado'] = $unidades_totales_producidas[0]->esta_aprobado;
        

        return $array_resultados;
    }
}
