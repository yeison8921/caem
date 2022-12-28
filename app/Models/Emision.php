<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emision extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emisiones';

    protected $fillable = [
        'nombre',
        'unidad_consumo',
        'factor_emision_co2',
        'unidad_factor_emision_co2',
        'incertidumbre_co2_1',
        'incertidumbre_co2_2',
        'fuente_bibliografica_co2',
        'factor_emision_ch4',
        'unidad_factor_emision_ch4',
        'incertidumbre_ch4_1',
        'incertidumbre_ch4_2',
        'fuente_bibliografica_ch4',
        'tipo',
    ];
}
