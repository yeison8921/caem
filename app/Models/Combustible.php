<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combustible extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'unidad_consumo',
        'factor_emision_co2',
        'unidad_factor_emision_co2',
        'incertidumbre_co2_1',
        'incertidumbre_co2_2',
        'fuente_bibliografica_co2',
        'factor_emision_ch4g_fuente_fija',
        'factor_emision_ch4kg_fuente_fija',
        'unidad_factor_emision_ch4_fuente_fija',
        'incertidumbre_ch4_1_fuente_fija',
        'incertidumbre_ch4_2_fuente_fija',
        'fuente_bibliografica_ch4_fuente_fija',
        'factor_emision_n2og_fuente_fija',
        'factor_emision_n2okg_fuente_fija',
        'unidad_factor_emision_n2o_fuente_fija',
        'incertidumbre_n2o_1_fuente_fija',
        'incertidumbre_n2o_2_fuente_fija',
        'fuente_bibliografica_n2o_fuente_fija',
        'factor_emision_ch4g_fuente_movil',
        'factor_emision_ch4kg_fuente_movil',
        'unidad_factor_emision_ch4_fuente_movil',
        'incertidumbre_ch4_1_fuente_movil',
        'incertidumbre_ch4_2_fuente_movil',
        'fuente_bibliografica_ch4_fuente_movil',
        'factor_emision_n2og_fuente_movil',
        'factor_emision_n2okg_fuente_movil',
        'unidad_factor_emision_n2o_fuente_movil',
        'incertidumbre_n2o_1_fuente_movil',
        'incertidumbre_n2o_2_fuente_movil',
        'fuente_bibliografica_n2o_fuente_movil',
        'tipo',
        'biogenico'
    ];
}
