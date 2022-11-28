<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuenteEmision extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fuentes_emision';

    protected $fillable = [
        'tipo',
        'modelo',
        'modelo_id',
        'fuente_emision',
        'descripcion',
        'informacion_adicional',
        'dato_mes_1',
        'dato_mes_2',
        'dato_mes_3',
        'dato_mes_4',
        'dato_mes_5',
        'dato_mes_6',
        'dato_mes_7',
        'dato_mes_8',
        'dato_mes_9',
        'dato_mes_10',
        'dato_mes_11',
        'dato_mes_12',
        'subproceso_id',
        'informacion_empresa_id',
        'empresa_id',
        'sede_id',
    ];

    protected $appends = ['tipo_mostrar', 'fuente_emision_mostrar'];
    //protected $appends = array('fecha_mostrar', 'franja_atencion_mostrar', 'tipo_evento_mostrar');

    /**
     * Obtiene el tipo de emisión en formato de lectura para el usuario.
     *
     * @param  string  $value
     * @return string
     */
    public function getTipoMostrarAttribute()
    {
        $texto = '';
        switch ($this->tipo) {
            case 'fuentes_fijas':
                $texto = 'Fuentes fijas';
                break;
            case 'fuentes_moviles':
                $texto = 'Fuentes móviles';
                break;
            case 'emisiones':
                $texto = 'Emisiones de proceso';
                break;
            case 'agricolas':
                $texto = 'Agricolas';
                break;
            case 'extintores':
                $texto = 'Extintores';
                break;
        }
        return $texto;
    }

    /**
     * Obtiene la fuente de emisión en formato de lectura para el usuario.
     *
     * @param  string  $value
     * @return string
     */
    public function getFuenteEmisionMostrarAttribute()
    {
        $texto = '';
        switch ($this->fuente_emision) {
            case 'combustibles_solidos':
                $texto = 'Consumo de combustibles solidos';
                break;
            case 'combustibles_liquidos':
                $texto = 'Consumo de combustibles líquidos';
                break;
            case 'combustibles_gaseosos':
                $texto = 'Consumo de combustibles gaseosos';
                break;
            case 'refrigerantes':
                $texto = 'Refrigerantes';
                break;
            case 'extintores':
                $texto = 'Extintores';
                break;
            case 'lubricantes':
                $texto = 'Lubricantes';
                break;
            case 'refrigerantes':
                $texto = 'Consumo de refrigerantes';
                break;
            case 'fugas':
                $texto = 'Fugas de CO2 en proceso';
                break;
            case 'aislamientos':
                $texto = 'Consumo de aislante eléctrico';
                break;
            case 'embalses':
                $texto = 'Manejo de embalses';
                break;
            case 'minerias':
                $texto = 'Minería';
                break;
            case 'industriales':
                $texto = 'Industrial';
                break;
            case 'fermentaciones':
                $texto = 'Fermentación Entérica';
                break;
            case 'estiercoles':
                $texto = 'Manejo de Estiércol';
                break;
            case 'residuos_agropecuarios':
                $texto = 'Manejo de residuos agropecuarios';
                break;
            case 'fertilizantes':
                $texto = 'Uso fertilizantes';
                break;
            case 'cales':
                $texto = 'Cal aplicada';
                break;
            case 'residuos_organizacionales':
                $texto = 'Manejo residuos organizacionales';
                break;
        }
        return $texto;
    }

    /**
     * Obtiene el combustible
     */
    public function combustible()
    {
        return $this->belongsTo(Combustible::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el refrigerante
     */
    public function refrigerante()
    {
        return $this->belongsTo(Refrigerante::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el extintor
     */
    public function extintor()
    {
        return $this->belongsTo(Extintor::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el lubricante
     */
    public function lubricante()
    {
        return $this->belongsTo(Lubricante::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene la fuga
     */
    public function fuga()
    {
        return $this->belongsTo(fuga::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el aislamiento
     */
    public function aislamiento()
    {
        return $this->belongsTo(Aislamiento::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el emision
     */
    public function emision()
    {
        return $this->belongsTo(Emision::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el fermentacion
     */
    public function fermentacion()
    {
        return $this->belongsTo(Fermentacion::class, 'modelo_id', 'id');
    }

    /**
     * Obtiene el estiercol
     */
    public function estiercol()
    {
        return $this->belongsTo(Estiercol::class, 'modelo_id', 'id');
    }
}
