<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoFuenteEmision extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasFactory;
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
        'factor_emision_co2',
        'unidad_factor_emision_co2',
        'incertidumbre_factor_emision_co2',
        'emision_co2_ton',
        'emision_co2_ton_eq',
        'incertidumbre_emision_co2',
        'columna_auxiliar_co2',
        'factor_emision_ch4',
        'unidad_factor_emision_ch4',
        'incertidumbre_factor_emision_ch4',
        'emision_ch4_ton',
        'emision_ch4_ton_eq',
        'incertidumbre_emision_ch4',
        'columna_auxiliar_ch4',
        'factor_emision_n2o',
        'unidad_factor_emision_n2o',
        'incertidumbre_factor_emision_n2o',
        'emision_n2o_ton',
        'emision_n2o_ton_eq',
        'incertidumbre_emision_n2o',
        'columna_auxiliar_n2o',
        'factor_emision_compuestos_fluorados',
        'unidad_factor_emision_compuestos_fluorados',
        'incertidumbre_factor_emision_compuestos_fluorados',
        'emision_compuestos_fluorados_ton',
        'emision_compuestos_fluorados_ton_eq',
        'incertidumbre_emision_compuestos_fluorados',
        'columna_auxiliar_compuestos_fluorados',
        'factor_emision_sf6',
        'unidad_factor_emision_sf6',
        'incertidumbre_factor_emision_sf6',
        'emision_sf6_ton',
        'emision_sf6_ton_eq',
        'incertidumbre_emision_sf6',
        'columna_auxiliar_sf6',
        'factor_emision_nf3',
        'unidad_factor_emision_nf3',
        'incertidumbre_factor_emision_nf3',
        'emision_nf3_ton',
        'emision_nf3_ton_eq',
        'incertidumbre_emision_nf3',
        'columna_auxiliar_nf3',
        'huella_carbono',
        'incertidumbre_fuente',
        'informacion_empresa_id',
        'empresa_id',
        'sede_id',
    ];
}
