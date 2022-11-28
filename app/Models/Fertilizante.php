<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fertilizante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'unidad_consumo',
        'factor_emision_no2',
        'unidad_factor_emision_no2',
        'incertidumbre_no2_1',
        'incertidumbre_no2_2',
        'fuente_bibliografica_no2',
        'tipo',
    ];
}
