<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\FuenteEmision;
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

    public function guardarEmisionesIndirectas($emisiones)
    {
        foreach ($emisiones['emisiones'] as $ke => $e) {
            foreach ($e as $ksf => $sf) {
                $modelo = 'App\Models\\';

                if (str_contains($ksf, 'Combustible')) {
                    $modelo .= 'Combustible';
                } elseif ($ksf == 'Embalse' || $ksf == 'Mineria' || $ksf == 'Industrial' || $ksf == 'Residuo_organizacional' || $ksf == 'Residuo') {
                    $modelo .= 'Emision';
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
                        $fuente_emision->informacion_empresa_id = 1;
                        $fuente_emision->empresa_id = 1;
                        $fuente_emision->sede_id = 1;
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
                    $fuentes[$i][$si]["resultado"]->factor_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_co2_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_co2 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_ch4_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_ch4 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_n2o_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_n2o = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_compuestos_fluorados_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_compuestos_fluorados = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_sf6_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_sf6 = 0;
                    $fuentes[$i][$si]["resultado"]->factor_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->unidad_factor_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_factor_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton = 0;
                    $fuentes[$i][$si]["resultado"]->emision_nf3_ton_eq = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_emision_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->columna_auxiliar_nf3 = 0;
                    $fuentes[$i][$si]["resultado"]->huella_carbono = 0;
                    $fuentes[$i][$si]["resultado"]->incertidumbre_fuente = 0;
                    $fuentes[$i][$si]["resultado"]->informacion_empresa_id = $fuentes[$i][$si]["informacion_empresa_id"];
                    $fuentes[$i][$si]["resultado"]->empresa_id = $fuentes[$i][$si]["empresa_id"];
                    $fuentes[$i][$si]["resultado"]->sede_id = $fuentes[$i][$si]["sede_id"];
                }
            }
        }
        return $fuentes;
    }
}
