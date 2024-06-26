<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultadoFuenteEmision extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resultados_fuente_emision';

    protected $fillable = [
        'fuentetable_type',
        'fuentetable_id',
        'tipo',
        'fuente_emision',
        'descripcion_fuente_emision',
        'dato_1',
        'dato_2',
        'dato_3',
        'dato_4',
        'dato_5',
        'dato_6',
        'dato_7',
        'dato_8',
        'dato_9',
        'dato_10',
        'dato_11',
        'dato_12',
        'total',
        'numero_datos',
        'promedio',
        'desviacion_estandar',
        'factor_t',
        'incertidumbre_sistematica_adicional',
        'incertidumbre_datos',
        'factor_emision_co2_biogenico_ar5',
        'unidad_factor_emision_co2_biogenico_ar5',
        'incertidumbre_factor_emision_co2_biogenico_ar5',
        'emision_co2_ton_biogenico_ar5',
        'emision_co2_ton_eq_biogenico_ar5',
        'incertidumbre_emision_co2_biogenico_ar5',
        'columna_auxiliar_co2_biogenico_ar5',
        'factor_emision_co2_ar5',
        'unidad_factor_emision_co2_ar5',
        'incertidumbre_factor_emision_co2_ar5',
        'emision_co2_ton_ar5',
        'emision_co2_ton_eq_ar5',
        'incertidumbre_emision_co2_ar5',
        'columna_auxiliar_co2_ar5',
        'factor_emision_ch4_ar5',
        'unidad_factor_emision_ch4_ar5',
        'incertidumbre_factor_emision_ch4_ar5',
        'emision_ch4_ton_ar5',
        'emision_ch4_ton_eq_ar5',
        'incertidumbre_emision_ch4_ar5',
        'columna_auxiliar_ch4_ar5',
        'factor_emision_n2o_ar5',
        'unidad_factor_emision_n2o_ar5',
        'incertidumbre_factor_emision_n2o_ar5',
        'emision_n2o_ton_ar5',
        'emision_n2o_ton_eq_ar5',
        'incertidumbre_emision_n2o_ar5',
        'columna_auxiliar_n2o_ar5',
        'factor_emision_compuestos_fluorados_ar5',
        'unidad_factor_emision_compuestos_fluorados_ar5',
        'incertidumbre_factor_emision_compuestos_fluorados_ar5',
        'emision_compuestos_fluorados_ton_ar5',
        'emision_compuestos_fluorados_ton_eq_ar5',
        'incertidumbre_emision_compuestos_fluorados_ar5',
        'columna_auxiliar_compuestos_fluorados_ar5',
        'factor_emision_sf6_ar5',
        'unidad_factor_emision_sf6_ar5',
        'incertidumbre_factor_emision_sf6_ar5',
        'emision_sf6_ton_ar5',
        'emision_sf6_ton_eq_ar5',
        'incertidumbre_emision_sf6_ar5',
        'columna_auxiliar_sf6_ar5',
        'factor_emision_nf3_ar5',
        'unidad_factor_emision_nf3_ar5',
        'incertidumbre_factor_emision_nf3_ar5',
        'emision_nf3_ton_ar5',
        'emision_nf3_ton_eq_ar5',
        'incertidumbre_emision_nf3_ar5',
        'columna_auxiliar_nf3_ar5',
        'huella_carbono_ar5',
        'incertidumbre_fuente_ar5',
        'huella_carbono_biogenico_ar5',
        'incertidumbre_fuente_biogenico_ar5',
        'factor_emision_co2_biogenico_ar6',
        'unidad_factor_emision_co2_biogenico_ar6',
        'incertidumbre_factor_emision_co2_biogenico_ar6',
        'emision_co2_ton_biogenico_ar6',
        'emision_co2_ton_eq_biogenico_ar6',
        'incertidumbre_emision_co2_biogenico_ar6',
        'columna_auxiliar_co2_biogenico_ar6',
        'factor_emision_co2_ar6',
        'unidad_factor_emision_co2_ar6',
        'incertidumbre_factor_emision_co2_ar6',
        'emision_co2_ton_ar6',
        'emision_co2_ton_eq_ar6',
        'incertidumbre_emision_co2_ar6',
        'columna_auxiliar_co2_ar6',
        'factor_emision_ch4_ar6',
        'unidad_factor_emision_ch4_ar6',
        'incertidumbre_factor_emision_ch4_ar6',
        'emision_ch4_ton_ar6',
        'emision_ch4_ton_eq_ar6',
        'incertidumbre_emision_ch4_ar6',
        'columna_auxiliar_ch4_ar6',
        'factor_emision_n2o_ar6',
        'unidad_factor_emision_n2o_ar6',
        'incertidumbre_factor_emision_n2o_ar6',
        'emision_n2o_ton_ar6',
        'emision_n2o_ton_eq_ar6',
        'incertidumbre_emision_n2o_ar6',
        'columna_auxiliar_n2o_ar6',
        'factor_emision_compuestos_fluorados_ar6',
        'unidad_factor_emision_compuestos_fluorados_ar6',
        'incertidumbre_factor_emision_compuestos_fluorados_ar6',
        'emision_compuestos_fluorados_ton_ar6',
        'emision_compuestos_fluorados_ton_eq_ar6',
        'incertidumbre_emision_compuestos_fluorados_ar6',
        'columna_auxiliar_compuestos_fluorados_ar6',
        'factor_emision_sf6_ar6',
        'unidad_factor_emision_sf6_ar6',
        'incertidumbre_factor_emision_sf6_ar6',
        'emision_sf6_ton_ar6',
        'emision_sf6_ton_eq_ar6',
        'incertidumbre_emision_sf6_ar6',
        'columna_auxiliar_sf6_ar6',
        'factor_emision_nf3_ar6',
        'unidad_factor_emision_nf3_ar6',
        'incertidumbre_factor_emision_nf3_ar6',
        'emision_nf3_ton_ar6',
        'emision_nf3_ton_eq_ar6',
        'incertidumbre_emision_nf3_ar6',
        'columna_auxiliar_nf3_ar6',
        'huella_carbono_ar6',
        'incertidumbre_fuente_ar6',
        'huella_carbono_biogenico_ar6',
        'incertidumbre_fuente_biogenico_ar6',
        'informacion_empresa_id',
        'empresa_id',
        'sede_id',
    ];
}
