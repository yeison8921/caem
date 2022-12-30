<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\FuenteEmision;
use App\Models\InformacionEmpresa;
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

    public function recargarEmisiones($request)
    {
        $fuentes = FuenteEmision::whereNull('subproceso_id')->where([
            ['empresa_id', $request->empresa_id],
            ['sede_id', $request->sede_id],
            ['fuente_emision', '!=', 'Trasversal']
        ])->get();

        $jei = new stdClass();

        if (!$fuentes->isEmpty()) {
            $je = new stdClass();
            $je->Energia_electrica = [];
            $je->Combustible_solido = [];
            $je->Combustible_liquido = [];
            $je->Combustible_gaseoso = [];

            $jt = new stdClass();
            $jt->Combustible_solido = [];
            $jt->Combustible_liquido = [];
            $jt->Combustible_gaseoso = [];
            $jt->Refrigerante = [];
            $jt->Extintor = [];
            $jt->Lubricante = [];
            $jt->Transporte = [];

            $jp = new stdClass();
            $jp->Refrigerante = [];
            $jp->Extintor = [];
            $jp->Lubricante = [];
            $jp->Aislamiento = [];
            $jp->Equipo = [];
            $jp->Materia_prima = [];
            $jp->Residuo = [];

            $ju = new stdClass();
            $ju->Producto = [];

            $jf = new stdClass();
            $jf->Producto = [];

            $ja = new stdClass();
            $ja->Activo = [];

            $ji = new stdClass();
            $ji->Inversion = [];

            $jo = new stdClass();
            $jo->Otro = [];

            foreach ($fuentes as $f) {
                $fuente = $f->fuente_emision;

                if ($f->tipo == 'energias') {
                    array_push($je->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'transportes') {
                    array_push($jt->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'productos') {
                    array_push($jp->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'usos') {
                    array_push($ju->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'fines') {
                    array_push($jf->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'activos') {
                    array_push($ja->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'inversiones') {
                    array_push($ji->$fuente, $f->fuentetable_id);
                }
                if ($f->tipo == 'otros') {
                    array_push($jo->$fuente, $f->fuentetable_id);
                }
            }

            $jei->energias = $je;
            $jei->transportes = $jt;
            $jei->productos = $jp;
            $jei->usos = $ju;
            $jei->fines = $jf;
            $jei->activos = $ja;
            $jei->inversiones = $ji;
            $jei->otros = $jo;
        }

        return $jei;
    }
    public function recargarTrasversales($request)
    {
        $fuentes = FuenteEmision::whereNull('subproceso_id')->where([
            ['empresa_id', $request->empresa_id],
            ['sede_id', $request->sede_id],
            ['fuente_emision', 'Trasversal']
        ])->get();

        $jtr = new stdClass();

        if (!$fuentes->isEmpty()) {
            $jt = new stdClass();
            $jt->Trasversal = [];

            foreach ($fuentes as $f) {
                $fuente = $f->fuente_emision;
                array_push($jt->$fuente, $f->fuentetable_id);
            }

            $jtr->trasversales = $jt;
        }
        return $jtr;
    }

    public function guardarTrasversales($trasversales)
    {
        foreach ($trasversales['trasversales'] as $ke => $e) {
            foreach ($e as $ksf => $sf) {
                foreach ($sf as $v) {
                    $fuente_emision = new FuenteEmision;
                    $fuente_emision->tipo = 'trasversales';
                    $fuente_emision->fuente_emision = 'Trasversal';
                    $fuente_emision->fuentetable_type = 'App\Models\\Trasversal';
                    $fuente_emision->fuentetable_id = $v;
                    $usuarioEmpresaId = auth('api')->user()->empresa_id;
                    $usuarioSedeId = auth('api')->user()->sede_id;
                    $informacionEmpresa = InformacionEmpresa::where('empresa_id', $usuarioEmpresaId)->where('sede_id', $usuarioSedeId)->first();
                    $fuente_emision->informacion_empresa_id = $informacionEmpresa->id;
                    $fuente_emision->empresa_id = $usuarioEmpresaId;
                    $fuente_emision->sede_id = $usuarioSedeId;
                    $fuente_emision->save();
                }
            }
        }
    }

    public function guardarEmisionesIndirectas($emisiones)
    {
        foreach ($emisiones['emisiones'] as $ke => $e) {
            foreach ($e as $ksf => $sf) {
                $modelo = 'App\Models\\';

                if (str_contains($ksf, 'Combustible')) {
                    $modelo .= 'Combustible';
                } elseif ($ksf == 'Embalse' || $ksf == 'Mineria' || $ksf == 'Industrial' || $ksf == 'Residuo_organizacional' || $ksf == 'Residuo') {
                    $modelo .= 'Emision';
                } elseif ($ksf == 'Producto' || $ksf == 'Activo' || $ksf == 'Inversion' || $ksf == 'Otro') {
                    $modelo .= 'Sf6';
                } elseif ($ksf == 'Cal') {
                    $modelo .= 'Fertilizante';
                } elseif ($ksf == 'Energia_electrica') {
                    $modelo .= 'Electricidad';
                } elseif ($ksf == 'Materia_prima') {
                    $modelo .= 'Aislamiento';
                } elseif ($ksf == 'Transporte') {
                    $modelo .= 'Viaje';
                } elseif ($ksf == 'Equipo') {
                    $modelo .= 'Fuga';
                } else {
                    $modelo .= $ksf;
                }

                foreach ($sf as $v) {
                    if ($v != -1) {
                        $fuente_emision = new FuenteEmision;
                        $fuente_emision->tipo = $ke;
                        $fuente_emision->fuente_emision = $ksf;
                        $fuente_emision->fuentetable_type = $modelo;
                        $fuente_emision->fuentetable_id = $v;
                        //por validar el id de la empresa, sede e informacion se envia desde el vue
                        $usuarioEmpresaId = auth('api')->user()->empresa_id;
                        $usuarioSedeId = auth('api')->user()->sede_id;
                        $informacionEmpresa = InformacionEmpresa::where('empresa_id', $usuarioEmpresaId)->where('sede_id', $usuarioSedeId)->first();
                        $fuente_emision->informacion_empresa_id = $informacionEmpresa->id;
                        $fuente_emision->empresa_id = $usuarioEmpresaId;
                        $fuente_emision->sede_id = $usuarioSedeId;
                        $fuente_emision->save();
                    }
                }
            }
        }
    }

    public function getFuentesEmision($id_empresa, $id_sede)
    {
        $fuentes = FuenteEmision::groupBy('fuentetable_type', 'fuentetable_id', 'tipo')
            ->with('fuentetable', 'resultado')
            ->where([['empresa_id', $id_empresa], ['sede_id', $id_sede]])
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
                    $fuentes[$i][$si]["resultado"]->incertidumbre_sistematica_adicional = '';
                    $fuentes[$i][$si]["resultado"]->total = 0;
                    $fuentes[$i][$si]["resultado"]->numero_datos = 0;
                    $fuentes[$i][$si]["resultado"]->promedio = 0;
                    $fuentes[$i][$si]["resultado"]->desviacion_estandar = 0;
                    $fuentes[$i][$si]["resultado"]->factor_t = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_datos = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2_biogenico = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_ch4 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_n2o = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_compuestos_fluorados = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_sf6 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_nf3 = '';
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente_biogenico = 0;
                    $fuentes[$i][$si]["resultado"]->informacion_empresa_id = $fuentes[$i][$si]["informacion_empresa_id"];
                    $fuentes[$i][$si]["resultado"]->empresa_id = $fuentes[$i][$si]["empresa_id"];
                    $fuentes[$i][$si]["resultado"]->sede_id = $fuentes[$i][$si]["sede_id"];
                }
            }
        }

        return $fuentes;
    }
}
