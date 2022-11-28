<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fermentacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fermentaciones';

    protected $fillable = [
        'nombre',
        'unidad_consumo',
        'factor_emision_ch4',
        'unidad_factor_emision_ch4',
        'incertidumbre_ch4_1',
        'incertidumbre_ch4_2',
        'fuente_bibliografica_ch4',

    ];
}
