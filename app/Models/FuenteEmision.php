<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuenteEmision extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fuentes_emision';

    protected $fillable = [
        'fuentetable_type',
        'fuentetable_id',
        'tipo',
        'fuente_emision',
        'descripcion',
        'informacion_adicional',
        'subproceso_id',
        'informacion_empresa_id',
        'empresa_id',
        'sede_id',
    ];

    protected $appends = ['tipo_mostrar', 'fuente_emision_mostrar', 'categoria_mostrar'];

    public function fuentetable()
    {
        return $this->morphTo();
    }

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
            case 'energias':
                $texto = 'Electricidad importada';
                break;
            case 'transportes':
                $texto = 'Transporte carga y pasajeros';
                break;
            case 'productos':
                $texto = 'Bienes y servicios';
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
            case 'Combustible_solido':
                $texto = 'Consumo de combustibles solidos';
                break;
            case 'Combustible_liquido':
                $texto = 'Consumo de combustibles líquidos';
                break;
            case 'Combustible_gaseoso':
                $texto = 'Consumo de combustibles gaseosos';
                break;
            case 'Refrigerante':
                $texto = 'Refrigerantes';
                break;
            case 'Extintor':
                $texto = 'Extintores';
                break;
            case 'Lubricante':
                $texto = 'Lubricantes';
                break;
            case 'Refrigerante':
                $texto = 'Consumo de refrigerantes';
                break;
            case 'Fuga':
                $texto = 'Fugas de CO2 en proceso';
                break;
            case 'Aislamiento':
                $texto = 'Consumo de aislante eléctrico';
                break;
            case 'Embalse':
                $texto = 'Manejo de embalses';
                break;
            case 'Mineria':
                $texto = 'Minería';
                break;
            case 'Industrial':
                $texto = 'Industrial';
                break;
            case 'Fermentacion':
                $texto = 'Fermentación Entérica';
                break;
            case 'Estiercol':
                $texto = 'Manejo de Estiércol';
                break;
            case 'Residuo_agropecuario':
                $texto = 'Manejo de residuos agropecuarios';
                break;
            case 'Fertilizante':
                $texto = 'Uso fertilizantes';
                break;
            case 'Cal':
                $texto = 'Cal aplicada';
                break;
            case 'Residuo_organizacional':
                $texto = 'Manejo residuos organizacionales';
                break;
            case 'Energia_electrica':
                $texto = 'Consumo de energía eléctrica';
                break;
            case 'Transporte':
                $texto = 'Transporte de carga';
                break;
            case 'Residuo':
                $texto = 'Manejo de residuos';
                break;
            case 'Materia_prima':
                $texto = 'Materias primas';
                break;
        }
        return $texto;
    }

    /**
     * Obtiene la categoría a mostrar.
     *
     * @param  string  $value
     * @return string
     */
    public function getCategoriaMostrarAttribute()
    {
        $texto = '';
        switch ($this->tipo) {
            case 'fuentes_fijas':
                $texto = 'CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI';
                break;
            case 'fuentes_moviles':
                $texto = 'CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI';
                break;
            case 'emisiones':
                $texto = 'CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI';
                break;
            case 'agricolas':
                $texto = 'CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI';
                break;
            case 'energias':
                $texto = 'CATEGORIA 2 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR ENERGÍA IMPORTADA';
                break;
            case 'transportes':
                $texto = 'CATEGORIA 3 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR EL TRANSPORTE';
                break;
            case 'productos':
                $texto = 'CATEGORIA 4 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR PRODUCTOS QUE UTILIZA LA ORGANIZACIÓN';
                break;
        }
        return $texto;
    }


    /**
     * Obtiene el combustible
     */
    public function combustible()
    {
        return $this->belongsTo('App\Models\Combustible', 'modeltable');
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

    /**
     * Obtiene el subproceso de la fuente de emision
     */
    public function subproceso()
    {
        return $this->belongsTo(Subproceso::class);
    }

    /**
     * Obtiene el resultado de la fuente de emision
     */
    public function resultado()
    {
        return $this->hasOne(ResultadoFuenteEmision::class, [
            'fuentetable_type', 'fuentetable_id', 'tipo', 'informacion_empresa_id', 'empresa_id', 'sede_id',
        ], [
            'fuentetable_type', 'fuentetable_id', 'tipo', 'informacion_empresa_id', 'empresa_id', 'sede_id',
        ]);
    }
}
