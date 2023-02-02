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
            case 'usos':
                $texto = 'Uso de productos';
                break;
            case 'otros':
                $texto = 'Otros';
                break;
            case 'trasversales':
                $texto = 'Trasversales';
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
                $texto = 'Consumo de refrigerantes y espumantes';
                break;
            case 'Extintor':
                $texto = 'Uso de extintores';
                break;
            case 'Lubricante':
                $texto = 'Consumo de lubricantes';
                break;
            case 'Fuga':
                $texto = 'Fugas de CO2 en proceso';
                break;
            case 'Aislamiento':
                $texto = 'Consumo de aislante eléctrico';
                break;
            case 'Embalse':
                $texto = 'Uso de embalses o represamientos de agua';
                break;
            case 'Mineria':
                $texto = 'Procesos de minería';
                break;
            case 'Fermentacion':
                $texto = 'Procesos agricolas (ganadería - fermentación entérica)';
                break;
            case 'Estiercol':
                $texto = 'Procesos agrícolas (manejo de estiércol)';
                break;
            case 'Residuo_agropecuario':
                $texto = 'Proceso agrícolas (manejo de residuos agropecuarios)';
                break;
            case 'Fertilizante':
                $texto = 'Procesos agrícolas (uso de fertilizantes)';
                break;
            case 'Cal':
                $texto = 'Procesos con cal';
                break;
            case 'Residuo_organizacional':
                $texto = 'Procesos de gestión de residuos';
                break;
            case 'Energia_electrica':
                $texto = 'Consumo de energía eléctrica';
                break;
            case 'Transporte_carga':
                $texto = 'Transporte de carga';
                break;
            case 'Transporte_pasajeros':
                $texto = 'Transporte de pasajeros';
                break;
            case 'Materia_prima':
                $texto = 'Materias primas';
                break;
            case 'Fin':
                $texto = 'Fin de vida';
                break;
            case 'Inversion':
                $texto = 'Inversión';
                break;
            case 'Otros':

            default:
                $texto = $this->fuente_emision;
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
            case 'usos':
                $texto = 'CATEGORIA 5 - EMISIONES INDIRECTAS DE GEI ASOCIADAS CON EL USO DE LOS PRODUCTOS DE LA ORGANIZACIÓN';
                break;
            case 'otros':
                $texto = 'CATEGORIA 6 - EMISIONES INDIRECTAS DE GEI PROVENIENTES DE OTRAS FUENTES';
                break;
            case 'Trasversales':
                $texto = 'CATEGORIA 7 - EMISIONES TRASVERSALES';
                break;
        }
        return $texto;
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
