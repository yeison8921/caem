<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lubricante extends Model
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
    ];
}
