<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refrigerante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'unidad_consumo_1',
        'factor_emision_co2_1',
        'unidad_factor_emision_co2_1',
        'incertidumbre_co2_1_1',
        'incertidumbre_co2_1_2',
        'fuente_bibliografica_co2_1',
        'unidad_consumo_2',
        'factor_emision_co2_2',
        'unidad_factor_emision_co2_2',
        'incertidumbre_co2_2_1',
        'incertidumbre_co2_2_2',
        'fuente_bibliografica_co2_2',
    ];
}