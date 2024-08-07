<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\FuenteEmision;
use App\Models\ResultadoFuenteEmision;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * Class FuenteEmisionRepository.
 */
class FuenteEmisionRepository extends BaseRepository
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function model()
    {
        return FuenteEmision::class;
    }

    /**
     * @param array $data
     *
     * @return FuenteEmision
     * @throws \Exception
     * @throws \Throwable
     */
    // public function create(array $data): FuenteEmision
    // {
    //     return DB::transaction(function () use ($data) {
    //         $fuente_emision = FuenteEmision::create($data);
    //         if ($fuente_emision) {
    //             return $fuente_emision;
    //         }

    //         throw new GeneralException(__('backend_Fuentes_emision.exceptions.create_error'));
    //     });
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id_fuente_emision)
    {
        $fuente_emision = FuenteEmision::find($id_fuente_emision);
        $fuente_emision->update($request->all());

        return $fuente_emision;
    }

    public function guardarFuentesEmision($request)
    {
        if ($request->actualizar) {
            foreach ($request['fuentes'] as $key => $value) {
                foreach ($value as $subkey => $subvalue) {
                    $tipo = $subkey;
                    $array_nuevos[$tipo] = [];
                }
            }
            foreach ($request['fuentes'] as $key => $value) {
                foreach ($value as $subkey => $subvalue) {
                    foreach ($subvalue as $sk => $sv) {
                        foreach ($sv as $k => $v) {
                            $tipo = $subkey;
                            if (array_key_exists($tipo, $array_nuevos)) {
                                array_push($array_nuevos[$tipo], $v);
                            }
                        }
                    }
                }
            }

            foreach ($array_nuevos as $ka => $kv) {
                ResultadoFuenteEmision::where([
                    ['tipo', $ka],
                    ['empresa_id', $request->empresa_id],
                    ['sede_id', $request->sede_id],
                    ['informacion_empresa_id', $request->informacion_empresa_id],
                ])->whereNotIn('fuentetable_id', $array_nuevos[$ka])->delete();

                FuenteEmision::where([
                    ['tipo', $ka],
                    ['empresa_id', $request->empresa_id],
                    ['sede_id', $request->sede_id],
                    ['informacion_empresa_id', $request->informacion_empresa_id],
                ])->whereNotIn('fuentetable_id', $array_nuevos[$ka])->delete();
            }
        }

        foreach ($request['fuentes'] as $key => $value) {
            foreach ($value as $subkey => $subvalue) {
                foreach ($subvalue as $sk => $sv) {
                    foreach ($sv as $k => $v) {
                        $fuente_existe = FuenteEmision::where([
                            ['tipo', $subkey],
                            ['fuente_emision', $sk],
                            ['fuentetable_id', $v],
                            ['empresa_id', $request->empresa_id],
                            ['sede_id', $request->sede_id],
                            ['informacion_empresa_id', $request->informacion_empresa_id],
                        ])->first();

                        if (is_null($fuente_existe)) {
                            $modelo = 'App\Models\\';

                            if (str_contains($sk, 'Combustible')) {
                                $modelo .= explode("_", $sk)[0];
                            } elseif (str_contains($sk, 'Transporte')) {
                                $modelo .= 'Viaje';
                            } elseif ($sk == 'Embalse' || $sk == 'Mineria' || $sk == 'Industrial' || $sk == 'Residuo_organizacional') {
                                $modelo .= 'Emision';
                            } elseif ($sk == 'Producto' || $sk == 'Equipo' || $sk == 'Materia_prima' || $sk == 'Servicio' || $sk == 'Fin' || $sk == 'Activo' || $sk == 'Inversion' || $sk == 'Servicio') {
                                $modelo .= 'Producto';
                            } elseif ($sk == 'Cal') {
                                $modelo .= 'Fertilizante';
                            } elseif ($sk == 'Energia_electrica') {
                                $modelo .= 'Electricidad';
                            } elseif ($sk == 'Materia_prima') {
                                $modelo .= 'Aislamiento';
                            } elseif ($sk == 'Residuo_agropecuario') {
                                $modelo .= 'Estiercol';
                            } else {
                                $modelo .= $sk;
                            }

                            $fuente_emision = new FuenteEmision;
                            $fuente_emision->tipo = $subkey;
                            $fuente_emision->fuente_emision = $sk;
                            $fuente_emision->fuentetable_type = $modelo;
                            $fuente_emision->fuentetable_id = $v;
                            $fuente_emision->informacion_empresa_id = $request->informacion_empresa_id;
                            $fuente_emision->empresa_id = $request->empresa_id;
                            $fuente_emision->sede_id = $request->sede_id;
                            $fuente_emision->save();
                        }
                    }
                }
            }
        }
    }

    public function recargarFuentesEmision($request)
    {
        $data = FuenteEmision::whereNull('subproceso_id')->where([
            ['empresa_id', $request->empresa_id],
            ['sede_id', $request->sede_id],
            ['informacion_empresa_id', $request->informacion_empresa_id],
        ])->get();

        if ($data->isEmpty()) {
            return $data;
        }

        $jf = new \stdClass();
        $jf->c1 = new \stdClass();
        $jf->c2 = new \stdClass();
        $jf->c3 = new \stdClass();
        $jf->c4 = new \stdClass();
        $jf->c5 = new \stdClass();
        $jf->c6 = new \stdClass();
        $jf->c7 = new \stdClass();

        //json fuentes móviles
        $jfm = new stdClass();
        $jfm->Combustible_liquido = [];
        $jfm->Combustible_gaseoso = [];
        $jfm->Refrigerante = [];
        $jfm->Extintor = [];
        $jfm->Lubricante = [];

        //json fuentes fijas
        $jff = new stdClass();
        $jff->Combustible_solido = [];
        $jff->Combustible_liquido = [];
        $jff->Combustible_gaseoso = [];
        $jff->Refrigerante = [];
        $jff->Extintor = [];
        $jff->Lubricante = [];
        $jff->Fuga = [];
        $jff->Aislamiento = [];

        //json emisiones
        $jem = new stdClass();
        $jem->Embalse = [];
        $jem->Mineria = [];
        $jem->Industrial = [];
        $jem->Fermentacion = [];
        $jem->Estiercol = [];
        $jem->Residuo_organizacional = [];
        $jem->Residuo_agropecuario = [];
        $jem->Fertilizante = [];
        $jem->Cal = [];

        //json fuentes móviles biogenico
        $jfmb26 = new stdClass();
        $jfmb26->Combustible_liquido = [];

        $jfmb37 = new stdClass();
        $jfmb37->Combustible_liquido = [];

        $jfmb27 = new stdClass();
        $jfmb27->Combustible_liquido = [];

        $jfmb38 = new stdClass();
        $jfmb38->Combustible_liquido = [];

        //json fuentes fijas biogenico
        $jffb26 = new stdClass();
        $jffb26->Combustible_liquido = [];

        $jffb37 = new stdClass();
        $jffb37->Combustible_liquido = [];

        $jffb27 = new stdClass();
        $jffb27->Combustible_liquido = [];

        $jffb38 = new stdClass();
        $jffb38->Combustible_liquido = [];

        //json fuentes móviles corporativo
        $jfmc26 = new stdClass();
        $jfmc26->Combustible_liquido = [];

        $jfmc37 = new stdClass();
        $jfmc37->Combustible_liquido = [];

        $jfmc27 = new stdClass();
        $jfmc27->Combustible_liquido = [];

        $jfmc38 = new stdClass();
        $jfmc38->Combustible_liquido = [];

        //json fuentes fijas corporativo
        $jffc26 = new stdClass();
        $jffc26->Combustible_liquido = [];

        $jffc37 = new stdClass();
        $jffc37->Combustible_liquido = [];

        $jffc27 = new stdClass();
        $jffc27->Combustible_liquido = [];

        $jffc38 = new stdClass();
        $jffc38->Combustible_liquido = [];

        //json electricidad
        $jel = new stdClass();
        $jel->Energia_electrica = [];

        //json energia
        $jen = new stdClass();
        $jen->Combustible_solido = [];
        $jen->Combustible_liquido = [];
        $jen->Combustible_gaseoso = [];

        //json energia biogenica
        $jeib26 = new stdClass();
        $jeib26->Combustible_liquido = [];

        $jeib37 = new stdClass();
        $jeib37->Combustible_liquido = [];

        $jeib27 = new stdClass();
        $jeib27->Combustible_liquido = [];

        $jeib38 = new stdClass();
        $jeib38->Combustible_liquido = [];

        //json transportes fuentes móviles
        $jtfm = new stdClass();
        $jtfm->Combustible_solido = [];
        $jtfm->Combustible_liquido = [];
        $jtfm->Combustible_gaseoso = [];
        $jtfm->Refrigerante = [];
        $jtfm->Extintor = [];
        $jtfm->Lubricante = [];

        //json transportes carga pasajeros
        $jtcp = new stdClass();
        $jtcp->Transporte_carga = [];
        $jtcp->Transporte_pasajeros = [];
        $jtcp->Transporte_aereo = [];

        //json transporte biogenico
        $jtb26 = new stdClass();
        $jtb26->Combustible_liquido = [];

        $jtb37 = new stdClass();
        $jtb37->Combustible_liquido = [];

        $jtb27 = new stdClass();
        $jtb27->Combustible_liquido = [];

        $jtb38 = new stdClass();
        $jtb38->Combustible_liquido = [];

        //json bienes productos
        $jbp = new stdClass();
        $jbp->Refrigerante = [];
        $jbp->Extintor = [];
        $jbp->Lubricante = [];
        $jbp->Aislamiento = [];
        $jbp->Producto = [];
        $jbp->Equipo = [];
        $jbp->Materia_prima = [];

        //json servicios
        $js = new stdClass();
        $js->Servicio = [];
        $js->Residuo_organizacional = [];

        //json prosductos
        $jp = new stdClass();
        $jp->Producto = [];

        //json fines
        $jfi = new stdClass();
        $jfi->Fin = [];

        //json activos
        $ja = new stdClass();
        $ja->Activo = [];

        //json inversiones
        $ji = new stdClass();
        $ji->Inversion = [];

        //json otros
        $jo = new stdClass();
        $jo->Otro = [];

        //json trasversal
        $jt = new stdClass();
        $jt->Trasversal = [];

        foreach ($data as $k => $d) {
            $fuente = $d->fuente_emision;
            if ($d->tipo == 'fuentes_moviles') {
                array_push($jfm->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas') {
                array_push($jff->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'emisiones') {
                array_push($jem->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_biogenico_26') {
                array_push($jfmb26->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_biogenico_37') {
                array_push($jfmb37->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_biogenico_27') {
                array_push($jfmb27->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_biogenico_38') {
                array_push($jfmb38->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_biogenico_26') {
                array_push($jffb26->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_biogenico_37') {
                array_push($jffb37->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_biogenico_27') {
                array_push($jffb27->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_biogenico_38') {
                array_push($jffb38->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_corporativo_26') {
                array_push($jfmc26->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_corporativo_37') {
                array_push($jfmc37->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_corporativo_27') {
                array_push($jfmc27->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_moviles_corporativo_38') {
                array_push($jfmc38->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_corporativo_26') {
                array_push($jffc26->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_corporativo_37') {
                array_push($jffc37->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_corporativo_27') {
                array_push($jffc27->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fuentes_fijas_corporativo_38') {
                array_push($jffc38->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'electricidad_importada') {
                array_push($jel->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'energia_importada') {
                array_push($jen->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'energia_importada_biogenico_26') {
                array_push($jeib26->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'energia_importada_biogenico_37') {
                array_push($jeib37->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'energia_importada_biogenico_27') {
                array_push($jeib27->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'energia_importada_biogenico_38') {
                array_push($jeib38->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'transportes_fuentes_moviles') {
                array_push($jtfm->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'transportes_carga_pasajeros') {
                array_push($jtcp->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'transportes_fuentes_moviles_biogenico_26') {
                array_push($jtb26->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'transportes_fuentes_moviles_biogenico_37') {
                array_push($jtb37->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'transportes_fuentes_moviles_biogenico_27') {
                array_push($jtb27->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'transportes_fuentes_moviles_biogenico_38') {
                array_push($jtb38->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'bienes_productos') {
                array_push($jbp->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'servicios') {
                array_push($js->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'usos') {
                array_push($jp->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'fines') {
                array_push($jfi->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'activos') {
                array_push($ja->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'inversiones') {
                array_push($ji->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'otros') {
                array_push($jo->$fuente, $d->fuentetable_id);
            }
            if ($d->tipo == 'trasversales') {
                array_push($jt->$fuente, $d->fuentetable_id);
            }
        }

        $jf->c1->fuentes_moviles = $jfm;
        $jf->c1->fuentes_fijas = $jff;
        $jf->c1->emisiones = $jem;
        $jf->c1->fuentes_moviles_biogenico_26 = $jfmb26;
        $jf->c1->fuentes_moviles_biogenico_37 = $jfmb37;
        $jf->c1->fuentes_moviles_biogenico_27 = $jfmb27;
        $jf->c1->fuentes_moviles_biogenico_38 = $jfmb38;
        $jf->c1->fuentes_fijas_biogenico_26 = $jffb26;
        $jf->c1->fuentes_fijas_biogenico_37 = $jffb37;
        $jf->c1->fuentes_fijas_biogenico_27 = $jffb27;
        $jf->c1->fuentes_fijas_biogenico_38 = $jffb38;
        $jf->c1->fuentes_moviles_corporativo_26 = $jfmc26;
        $jf->c1->fuentes_moviles_corporativo_37 = $jfmc37;
        $jf->c1->fuentes_moviles_corporativo_27 = $jfmc27;
        $jf->c1->fuentes_moviles_corporativo_38 = $jfmc38;
        $jf->c1->fuentes_fijas_corporativo_26 = $jffc26;
        $jf->c1->fuentes_fijas_corporativo_37 = $jffc37;
        $jf->c1->fuentes_fijas_corporativo_27 = $jffc27;
        $jf->c1->fuentes_fijas_corporativo_38 = $jffc38;

        $jf->c2->electricidad_importada = $jel;
        $jf->c2->energia_importada = $jen;
        $jf->c2->energia_importada_biogenico_26 = $jeib26;
        $jf->c2->energia_importada_biogenico_37 = $jeib37;
        $jf->c2->energia_importada_biogenico_27 = $jeib27;
        $jf->c2->energia_importada_biogenico_38 = $jeib38;

        $jf->c3->transportes_fuentes_moviles = $jtfm;
        $jf->c3->transportes_carga_pasajeros = $jtcp;
        $jf->c3->transportes_fuentes_moviles_biogenico_26 = $jtb26;
        $jf->c3->transportes_fuentes_moviles_biogenico_37 = $jtb37;
        $jf->c3->transportes_fuentes_moviles_biogenico_27 = $jtb27;
        $jf->c3->transportes_fuentes_moviles_biogenico_38 = $jtb38;

        $jf->c4->bienes_productos = $jbp;
        $jf->c4->servicios = $js;

        $jf->c5->usos = $jp;
        $jf->c5->fines = $jfi;
        $jf->c5->activos = $ja;
        $jf->c5->inversiones = $ji;

        $jf->c6->otros = $jo;

        $jf->c7->trasversales = $jt;

        return $jf;
    }

    public function getFuentesEmision($request)
    {
        $fuentes = FuenteEmision::groupBy('fuentetable_type', 'fuentetable_id', 'tipo')
            ->with('fuentetable', 'resultado')
            ->where([
                ['empresa_id', $request->empresa_id],
                ['sede_id', $request->sede_id],
                ['informacion_empresa_id', $request->informacion_empresa_id],
            ])
            ->whereNull('subproceso_id')
            ->get()
            ->groupBy('tipo_mostrar');

        $fuentes = collect($fuentes)->toArray();

        foreach ($fuentes as $i => $fuente) {
            foreach ($fuente as $si => $f) {
                if (is_null($fuentes[$i][$si]['resultado'])) {
                    $fuentes[$i][$si]["resultado"] = new stdClass();
                    $fuentes[$i][$si]["resultado"]->id = '';
                    $fuentes[$i][$si]["resultado"]->fuentetable_type = $fuentes[$i][$si]["fuentetable_type"];
                    $fuentes[$i][$si]["resultado"]->fuentetable_id = $fuentes[$i][$si]["fuentetable_id"];
                    $fuentes[$i][$si]["resultado"]->tipo = $fuentes[$i][$si]["tipo"];
                    $fuentes[$i][$si]["resultado"]->descripcion_fuente_emision = '';
                    $fuentes[$i][$si]["resultado"]->fuente_emision = $fuentes[$i][$si]["fuente_emision"];
                    $fuentes[$i][$si]["resultado"]->dato_1 = '';
                    $fuentes[$i][$si]["resultado"]->dato_2 = '';
                    $fuentes[$i][$si]["resultado"]->dato_3 = '';
                    $fuentes[$i][$si]["resultado"]->dato_4 = '';
                    $fuentes[$i][$si]["resultado"]->dato_5 = '';
                    $fuentes[$i][$si]["resultado"]->dato_6 = '';
                    $fuentes[$i][$si]["resultado"]->dato_7 = '';
                    $fuentes[$i][$si]["resultado"]->dato_8 = '';
                    $fuentes[$i][$si]["resultado"]->dato_9 = '';
                    $fuentes[$i][$si]["resultado"]->dato_10 = '';
                    $fuentes[$i][$si]["resultado"]->dato_11 = '';
                    $fuentes[$i][$si]["resultado"]->dato_12 = '';
                    $fuentes[$i][$si]["resultado"]->numero_datos = 0;
                    $fuentes[$i][$si]["resultado"]->total = 0;
                    $fuentes[$i][$si]["resultado"]->promedio = 0;
                    $fuentes[$i][$si]["resultado"]->desviacion_estandar = 0;
                    $fuentes[$i][$si]["resultado"]->factor_t = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_sistematica_adicional = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_datos = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2_biogenico_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_ch4_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_ch4_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_ch4_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton_eq_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_ch4_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_ch4_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_n2o_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_n2o_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_n2o_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton_eq_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_n2o_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_n2o_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_compuestos_fluorados_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_compuestos_fluorados_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_compuestos_fluorados_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton_eq_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_compuestos_fluorados_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_compuestos_fluorados_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_sf6_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_sf6_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_sf6_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton_eq_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_sf6_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_sf6_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_nf3_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_nf3_ar5 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_nf3_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton_eq_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_nf3_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_nf3_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente_biogenico_ar5 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2_biogenico_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_ch4_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_ch4_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_ch4_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton_eq_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_ch4_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_ch4_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_n2o_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_n2o_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_n2o_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton_eq_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_n2o_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_n2o_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_compuestos_fluorados_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_compuestos_fluorados_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_compuestos_fluorados_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton_eq_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_compuestos_fluorados_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_compuestos_fluorados_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_sf6_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_sf6_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_sf6_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton_eq_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_sf6_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_sf6_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_nf3_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_nf3_ar6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_nf3_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton_eq_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_nf3_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_nf3_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente_biogenico_ar6 = 0;
                    $fuentes[$i][$si]["resultado"]->informacion_empresa_id = $fuentes[$i][$si]["informacion_empresa_id"];
                    $fuentes[$i][$si]["resultado"]->empresa_id = $fuentes[$i][$si]["empresa_id"];
                    $fuentes[$i][$si]["resultado"]->sede_id = $fuentes[$i][$si]["sede_id"];
                }
            }
        }

        return response()->json($fuentes)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
    /*
    Tabla 10 Emisiones Directas Discriminadas por GEI
    Tabla 11. Total Emisiones Discriminadas por GEI
    Tabla 12. Resultados totales del inventario corporativo de GEI
    Tabla 13. Factores de emisión", ""
    Tabla 14. Potenciales de Calentamiento Global
     */
    public function getTablesAndTotals($request)
    {

        $arSelected = $request->ar;
        //fuentes moviles
        $fuentesMoviles = $this->getFuentesByTipo($request, [
            'fuentes_moviles',
            //'fuentes_moviles_biogenico_26',
            //'fuentes_moviles_biogenico_37',
            //'fuentes_moviles_biogenico_27',
            //'fuentes_moviles_biogenico_38',
        ]);
        $fuentes = [
            'fuentes_moviles' => $this->getDataEmision($fuentesMoviles, $arSelected),
        ];
        //fuentes fijas
        $fuentesFijas = $this->getFuentesByTipo($request, [
            'fuentes_fijas',
            //'fuentes_fijas_biogenico_26',
            //'fuentes_fijas_biogenico_37',
            //'fuentes_fijas_biogenico_27',
            //'fuentes_fijas_biogenico_38',
        ]);
        $fuentes = array_merge($fuentes, [
            'fuentes_fijas' => $this->getDataEmision($fuentesFijas, $arSelected),
        ]);
        //fuentes emisiones
        $fuentesEmisiones = $this->getFuentesByTipo($request, 'emisiones');
        $fuentes = array_merge($fuentes, [
            'emisiones' => $this->getDataEmision($fuentesEmisiones, $arSelected),
        ]);
        //fuentes fuentes_directas
        $fuentes = array_merge($fuentes, [
            'fuentes_directas' => [
                'data' => [
                    [
                        'fuente' => 'fuentes_moviles',
                        'huella_carbono' => $fuentes['fuentes_moviles']['total_huella_carbono'],
                        'representacion' => '',
                        'incertidumbre' => $fuentes['fuentes_moviles']['total_incertidumbre_fuente'],
                    ],
                    [
                        'fuente' => 'fuentes_fijas',
                        'huella_carbono' => $fuentes['fuentes_fijas']['total_huella_carbono'],
                        'representacion' => '',
                        'incertidumbre' => $fuentes['fuentes_fijas']['total_incertidumbre_fuente'],
                    ],
                    [
                        'fuente' => 'emisiones',
                        'huella_carbono' => $fuentes['emisiones']['total_huella_carbono'],
                        'representacion' => '',
                        'incertidumbre' => $fuentes['emisiones']['total_incertidumbre_fuente'],
                    ],
                ],
                'total_huella_carbono' => round($fuentes['fuentes_moviles']['total_huella_carbono'] + $fuentes['fuentes_fijas']['total_huella_carbono'] + $fuentes['emisiones']['total_huella_carbono'], 4),
                'total_incertidumbre' => round($fuentes['fuentes_moviles']['total_incertidumbre_fuente'] + $fuentes['fuentes_fijas']['total_incertidumbre_fuente'] + $fuentes['emisiones']['total_incertidumbre_fuente'], 4),
            ],
        ]);
        ///fuentes_indirectas
        $fuentesC2 = $this->getFuentesByTipo($request, [
            'electricidad_importada',
            'energia_importada',
            //'energia_importada_biogenico_26',
            //'energia_importada_biogenico_37',
            //'energia_importada_biogenico_27',
            //'energia_importada_biogenico_38',
        ]);
        $fuentes = array_merge($fuentes, [
            'fuentes_indirectas' => $this->getDataEmision($fuentesC2, $arSelected),
        ]);
        //Emisiones Indirectas por transporte - categoría 3 - Tabla 6
        $fuentesC3 = $this->getFuentesByTipo($request, [
            'transportes_fuentes_moviles',
            'transportes_carga_pasajeros',
            //'transportes_fuentes_moviles_biogenico_26',
            //'transportes_fuentes_moviles_biogenico_37',
            //'transportes_fuentes_moviles_biogenico_27',
            //'transportes_fuentes_moviles_biogenico_38',
        ]);
        // echo json_encode($fuentesC3);
        $fuentes = array_merge($fuentes, [
            'fuentes_C3' => $this->getDataEmision($fuentesC3, $arSelected),
        ]);

        //Emisiones Indirectas por productos que utiliza la organización - categoría 4 - Tabla 7
        $fuentesC4 = $this->getFuentesByTipo($request, ['bienes_productos', 'servicios']);
        $fuentes = array_merge($fuentes, [
            'fuentes_C4' => $this->getDataEmision($fuentesC4, $arSelected),
        ]);
        //Emisiones Indirectas por uso de productos de la organización - categoría 5 - Tabla 8
        $fuentesC5 = $this->getFuentesByTipo($request, [
            'usos',
            'fines',
            'activos',
            'inversiones',
        ]);
        $fuentes = array_merge($fuentes, [
            'fuentes_C5' => $this->getDataEmision($fuentesC5, $arSelected),
        ]);
        //Emisiones Indirectas proveniente de otras fuentes - categoría 6 - Tabla 9
        $fuentesC6 = $this->getFuentesByTipo($request, ['otros']);
        $fuentes = array_merge($fuentes, [
            'fuentes_C6' => $this->getDataEmision($fuentesC6, $arSelected),
        ]);

        // subtotals table
        $fuentes = array_merge($fuentes, [
            'subtotals' => [
                'emisiones_directas' => $this->getSubtotals($fuentes, ['fuentes_moviles', 'fuentes_fijas', 'emisiones']),
                'emisiones_indirectas' => $this->getSubtotals($fuentes, ['fuentes_indirectas']),
                'emisiones_otras_indirectas' => $this->getSubtotals($fuentes, ['fuentes_C3', 'fuentes_C4', 'fuentes_C5', 'fuentes_C6']),
                'totals' => $this->getSubtotals($fuentes, ['fuentes_moviles', 'fuentes_fijas', 'emisiones', 'fuentes_indirectas', 'fuentes_C3', 'fuentes_C4', 'fuentes_C5', 'fuentes_C6']),
            ],

        ]);


        $fuentes = array_merge($fuentes, [
            'tabla_10' => [
                'total_CO2' => [
                    'cantidad' => $fuentesMoviles->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentesMoviles->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_co2_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_CH4' => [
                    'cantidad' => $fuentesMoviles->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentesMoviles->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_ch4_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_N2O' => [
                    'cantidad' => $fuentesMoviles->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentesMoviles->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_n2o_ton_eq' . $arSelected),
                        4
                    ), 'representacion' => 0,
                ],
                'total_compuestos_fluorados' => [
                    'cantidad' => $fuentesMoviles->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentesMoviles->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_SF6' => [
                    'cantidad' => $fuentesMoviles->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentesMoviles->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_sf6_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
            ],
        ]);
        $totalEmisionesDirectas = $fuentes['tabla_10']['total_CO2']['emisiones'] +
            $fuentes['tabla_10']['total_CH4']['emisiones'] +
            $fuentes['tabla_10']['total_N2O']['emisiones'] +
            $fuentes['tabla_10']['total_compuestos_fluorados']['emisiones'] +
            $fuentes['tabla_10']['total_SF6']['emisiones'];

        $fuentes['tabla_10']['total_CO2']['representacion'] = round($totalEmisionesDirectas ? (($fuentes['tabla_10']['total_CO2']['emisiones'] / $totalEmisionesDirectas) * 100) : 0, 5);
        $fuentes['tabla_10']['total_CH4']['representacion'] = round($totalEmisionesDirectas ? (($fuentes['tabla_10']['total_CH4']['emisiones'] / $totalEmisionesDirectas) * 100) : 0, 5);
        $fuentes['tabla_10']['total_N2O']['representacion'] = round($totalEmisionesDirectas ? (($fuentes['tabla_10']['total_N2O']['emisiones'] / $totalEmisionesDirectas) * 100) : 0, 5);
        $fuentes['tabla_10']['total_compuestos_fluorados']['representacion'] = round($totalEmisionesDirectas ? (($fuentes['tabla_10']['total_compuestos_fluorados']['emisiones'] / $totalEmisionesDirectas) * 100) : 0, 5);
        $fuentes['tabla_10']['total_SF6']['representacion'] = round($totalEmisionesDirectas ? (($fuentes['tabla_10']['total_SF6']['emisiones'] / $totalEmisionesDirectas) * 100) : 0, 5);


        $fuentes['tabla_10']['total_cantidad'] = $fuentes['tabla_10']['total_CO2']['cantidad'] +
            $fuentes['tabla_10']['total_CH4']['cantidad'] +
            $fuentes['tabla_10']['total_N2O']['cantidad'] +
            $fuentes['tabla_10']['total_compuestos_fluorados']['cantidad'] +
            $fuentes['tabla_10']['total_SF6']['cantidad'];
        $fuentes['tabla_10']['total_emisiones'] = $fuentes['tabla_10']['total_CO2']['emisiones'] +
            $fuentes['tabla_10']['total_CH4']['emisiones'] +
            $fuentes['tabla_10']['total_N2O']['emisiones'] +
            $fuentes['tabla_10']['total_compuestos_fluorados']['emisiones'] +
            $fuentes['tabla_10']['total_SF6']['emisiones'];
        $fuentes['tabla_10']['total_representacion'] = $fuentes['tabla_10']['total_CO2']['representacion'] +
            $fuentes['tabla_10']['total_CH4']['representacion'] +
            $fuentes['tabla_10']['total_N2O']['representacion'] +
            $fuentes['tabla_10']['total_compuestos_fluorados']['representacion'] +
            $fuentes['tabla_10']['total_SF6']['representacion'];

        $fuentes = array_merge($fuentes, [
            'tabla_11' => [
                'total_CO2' => [
                    'cantidad' =>
                    $fuentesMoviles->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC2->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC3->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC4->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC5->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC6->where('resultado.emision_co2_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentesMoviles->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesC2->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesC3->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesC4->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesC5->sum('resultado.emision_co2_ton_eq' . $arSelected) +
                            $fuentesC6->sum('resultado.emision_co2_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_CH4' => [
                    'cantidad' =>
                    $fuentesMoviles->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC2->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC3->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC4->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC5->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC6->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentesMoviles->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesC2->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesC3->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesC4->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesC5->sum('resultado.emision_ch4_ton_eq' . $arSelected) +
                            $fuentesC6->sum('resultado.emision_ch4_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_N2O' => [
                    'cantidad' =>
                    $fuentesMoviles->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC2->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC3->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC4->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC5->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC6->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentesMoviles->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesC2->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesC3->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesC4->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesC5->sum('resultado.emision_n2o_ton_eq' . $arSelected) +
                            $fuentesC6->sum('resultado.emision_n2o_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_compuestos_fluorados' => [
                    'cantidad' =>

                    $fuentesMoviles->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC2->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC3->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC4->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC5->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC6->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentesMoviles->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesC2->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesC3->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesC4->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesC5->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected) +
                            $fuentesC6->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_SF6' => [
                    'cantidad' =>

                    $fuentesMoviles->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesFijas->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesEmisiones->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC2->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC3->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC4->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC5->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id') +
                        $fuentesC6->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentesMoviles->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesFijas->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesEmisiones->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesC2->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesC3->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesC4->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesC5->sum('resultado.emision_sf6_ton_eq' . $arSelected) +
                            $fuentesC6->sum('resultado.emision_sf6_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
            ],
        ]);
        $totalEmisiones = $fuentes['tabla_11']['total_CO2']['emisiones'] +
            $fuentes['tabla_11']['total_CH4']['emisiones'] +
            $fuentes['tabla_11']['total_N2O']['emisiones'] +
            $fuentes['tabla_11']['total_compuestos_fluorados']['emisiones'] +
            $fuentes['tabla_11']['total_SF6']['emisiones'];

        $fuentes['tabla_11']['total_CO2']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_11']['total_CO2']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_11']['total_CH4']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_11']['total_CH4']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_11']['total_N2O']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_11']['total_N2O']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_11']['total_compuestos_fluorados']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_11']['total_compuestos_fluorados']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_11']['total_SF6']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_11']['total_SF6']['emisiones'] / $totalEmisiones) * 100) : 0, 5);


        $fuentes['tabla_11']['total_cantidad'] = $fuentes['tabla_11']['total_CO2']['cantidad'] +
            $fuentes['tabla_11']['total_CH4']['cantidad'] +
            $fuentes['tabla_11']['total_N2O']['cantidad'] +
            $fuentes['tabla_11']['total_compuestos_fluorados']['cantidad'] +
            $fuentes['tabla_11']['total_SF6']['cantidad'];
        $fuentes['tabla_11']['total_emisiones'] = $fuentes['tabla_11']['total_CO2']['emisiones'] +
            $fuentes['tabla_11']['total_CH4']['emisiones'] +
            $fuentes['tabla_11']['total_N2O']['emisiones'] +
            $fuentes['tabla_11']['total_compuestos_fluorados']['emisiones'] +
            $fuentes['tabla_11']['total_SF6']['emisiones'];
        $fuentes['tabla_11']['total_representacion'] = $fuentes['tabla_11']['total_CO2']['representacion'] +
            $fuentes['tabla_11']['total_CH4']['representacion'] +
            $fuentes['tabla_11']['total_N2O']['representacion'] +
            $fuentes['tabla_11']['total_compuestos_fluorados']['representacion'] +
            $fuentes['tabla_11']['total_SF6']['representacion'];





        $fuentes_bio = $this->getFuentesByTipo($request, [
            'fuentes_moviles_biogenico_26',
            'fuentes_moviles_biogenico_37',
            'fuentes_moviles_biogenico_27',
            'fuentes_moviles_biogenico_38',
            'fuentes_fijas_biogenico_26',
            'fuentes_fijas_biogenico_37',
            'fuentes_fijas_biogenico_27',
            'fuentes_fijas_biogenico_38',
            'energia_importada_biogenico_26',
            'energia_importada_biogenico_37',
            'energia_importada_biogenico_27',
            'energia_importada_biogenico_38',
            'transportes_fuentes_moviles_biogenico_26',
            'transportes_fuentes_moviles_biogenico_37',
            'transportes_fuentes_moviles_biogenico_27',
            'transportes_fuentes_moviles_biogenico_38',
        ]);


        $fuentes = array_merge($fuentes, [
            //'data_fuentes_bio' => $fuentes_bio,
            'tabla_12' => [
                'total_CO2' => [
                    'cantidad' =>
                    $fuentes_bio->where('resultado.emision_co2_ton_eq_biogenico' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' => round(
                        $fuentes_bio->sum('resultado.emision_co2_ton_eq_biogenico' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_CH4' => [
                    'cantidad' =>
                    $fuentes_bio->where('resultado.emision_ch4_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentes_bio->sum('resultado.emision_ch4_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_N2O' => [
                    'cantidad' =>
                    $fuentes_bio->where('resultado.emision_n2o_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentes_bio->sum('resultado.emision_n2o_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_compuestos_fluorados' => [
                    'cantidad' =>
                    $fuentes_bio->where('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentes_bio->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
                'total_SF6' => [
                    'cantidad' =>
                    $fuentes_bio->where('resultado.emision_sf6_ton_eq' . $arSelected, '!=', 0)->count('id'),
                    'emisiones' =>
                    round(
                        $fuentes_bio->sum('resultado.emision_sf6_ton_eq' . $arSelected),
                        4
                    ),
                    'representacion' => 0,
                ],
            ],
        ]);
        $totalEmisiones = $fuentes['tabla_12']['total_CO2']['emisiones'] +
            $fuentes['tabla_12']['total_CH4']['emisiones'] +
            $fuentes['tabla_12']['total_N2O']['emisiones'] +
            $fuentes['tabla_12']['total_compuestos_fluorados']['emisiones'] +
            $fuentes['tabla_12']['total_SF6']['emisiones'];

        $fuentes['tabla_12']['total_CO2']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_12']['total_CO2']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_12']['total_CH4']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_12']['total_CH4']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_12']['total_N2O']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_12']['total_N2O']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_12']['total_compuestos_fluorados']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_12']['total_compuestos_fluorados']['emisiones'] / $totalEmisiones) * 100) : 0, 5);
        $fuentes['tabla_12']['total_SF6']['representacion'] = round($totalEmisiones ? (($fuentes['tabla_12']['total_SF6']['emisiones'] / $totalEmisiones) * 100) : 0, 5);


        $fuentes['tabla_12']['total_cantidad'] = $fuentes['tabla_12']['total_CO2']['cantidad'] +
            $fuentes['tabla_12']['total_CH4']['cantidad'] +
            $fuentes['tabla_12']['total_N2O']['cantidad'] +
            $fuentes['tabla_12']['total_compuestos_fluorados']['cantidad'] +
            $fuentes['tabla_12']['total_SF6']['cantidad'];
        $fuentes['tabla_12']['total_emisiones'] = $fuentes['tabla_12']['total_CO2']['emisiones'] +
            $fuentes['tabla_12']['total_CH4']['emisiones'] +
            $fuentes['tabla_12']['total_N2O']['emisiones'] +
            $fuentes['tabla_12']['total_compuestos_fluorados']['emisiones'] +
            $fuentes['tabla_12']['total_SF6']['emisiones'];
        $fuentes['tabla_12']['total_representacion'] = $fuentes['tabla_12']['total_CO2']['representacion'] +
            $fuentes['tabla_12']['total_CH4']['representacion'] +
            $fuentes['tabla_12']['total_N2O']['representacion'] +
            $fuentes['tabla_12']['total_compuestos_fluorados']['representacion'] +
            $fuentes['tabla_12']['total_SF6']['representacion'];

        return response()->json($fuentes)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
    public function getSubtotals($fuentes, $arrFuentesNames)
    {
        $result = [
            'emision_co2_ton_eq' => 0,
            'emision_ch4_ton_eq' => 0,
            'emision_n2o_ton_eq' => 0,
            'emision_compuestos_fluorados_ton_eq' => 0,
            'emision_sf6_ton_eq' => 0,
            'total_huella_carbono' => 0,
            'representacion' => '',
            'total_incertidumbre_fuente' => 0,
        ];
        foreach ($arrFuentesNames as $fuenteName) {
            $result['emision_co2_ton_eq'] += $fuentes[$fuenteName]['emision_co2_ton_eq'];
            $result['emision_ch4_ton_eq'] += $fuentes[$fuenteName]['emision_ch4_ton_eq'];
            $result['emision_n2o_ton_eq'] += $fuentes[$fuenteName]['emision_n2o_ton_eq'];
            $result['emision_compuestos_fluorados_ton_eq'] += $fuentes[$fuenteName]['emision_compuestos_fluorados_ton_eq'];
            $result['emision_sf6_ton_eq'] += $fuentes[$fuenteName]['emision_sf6_ton_eq'];
            $result['total_huella_carbono'] += $fuentes[$fuenteName]['total_huella_carbono'];
            $result['total_incertidumbre_fuente'] += pow(($fuentes[$fuenteName]['total_incertidumbre_fuente'] * $fuentes[$fuenteName]['total_huella_carbono']), 2);
        }
        // round values
        $result['emision_co2_ton_eq'] = round($result['emision_co2_ton_eq'], 4);
        $result['emision_ch4_ton_eq'] = round($result['emision_ch4_ton_eq'], 4);
        $result['emision_n2o_ton_eq'] = round($result['emision_n2o_ton_eq'], 4);
        $result['emision_compuestos_fluorados_ton_eq'] = round($result['emision_compuestos_fluorados_ton_eq'], 4);
        $result['emision_sf6_ton_eq'] = round($result['emision_sf6_ton_eq'], 4);
        $result['total_huella_carbono'] = round($result['total_huella_carbono'], 4);
        $total_incertidumbre_fuente = $result['total_huella_carbono'] > 0 ? sqrt($result['total_incertidumbre_fuente']) / $result['total_huella_carbono'] : 0;
        $result['total_incertidumbre_fuente'] = round($total_incertidumbre_fuente, 4);

        return $result;
    }
    public function getDataEmision($fuente, $arSelected)
    {
        $huellaTotalFuente = $fuente->sum('resultado.huella_carbono' . $arSelected);

        return [
            'total_huella_carbono' => round($huellaTotalFuente, 4),
            'total_incertidumbre_fuente' => $huellaTotalFuente > 0 ? $this->getIncertidumbreFuente($fuente, $arSelected, $huellaTotalFuente) : 0,
            'emision_co2_ton_eq' => round($fuente->sum('resultado.emision_co2_ton_eq' . $arSelected), 4),
            'emision_ch4_ton_eq' => round($fuente->sum('resultado.emision_ch4_ton_eq' . $arSelected), 4),
            'emision_n2o_ton_eq' => round($fuente->sum('resultado.emision_n2o_ton_eq' . $arSelected), 4),
            'emision_compuestos_fluorados_ton_eq' => round($fuente->sum('resultado.emision_compuestos_fluorados_ton_eq' . $arSelected), 4),
            'emision_sf6_ton_eq' => round($fuente->sum('resultado.emision_sf6_ton_eq' . $arSelected), 4),
            'representacion' => '',
            'data' => $fuente,
        ];
    }
    public function getIncertidumbreFuente($fuente, $arSelected, $huellaTotalFuente)
    {
        $incertidumbre = 0;
        foreach ($fuente as $item) {
            $incertidumbre += pow(($item->resultado['incertidumbre_fuente' . $arSelected] * $item->resultado['huella_carbono' . $arSelected]), 2);
        }
        $incertidumbre = sqrt($incertidumbre) / $huellaTotalFuente;

        return round($incertidumbre, 4);
    }
    public function getFuentesByTipo($request, $tipo)
    {
        if (is_string($tipo)) {
            $tipo = [$tipo];
        }
        $fuentes = FuenteEmision::groupBy('fuentetable_type', 'fuentetable_id', 'tipo')
            ->with('fuentetable', 'resultado')
            ->where([
                ['empresa_id', $request->empresa_id],
                ['sede_id', $request->sede_id],
                ['informacion_empresa_id', $request->informacion_empresa_id],
            ])
            ->whereIn(
                'tipo',
                $tipo
            )
            ->whereNull('subproceso_id')
            ->get();

        return $fuentes;
    }
}
