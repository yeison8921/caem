<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacionEmpresa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'datos_proveedores',
        'fuentes_moviles',
        'actividad_agricola',
        'huella_base',
        'valor_huella_base',
        'huella_comparativo',
        'valor_huella_comparativo',
        'alcances_huella',
        'priorizacion',
        'indicador',
        'verificacion_interna',
        'optimizacion_procesos',
        'verificacion_tercero',
        'declaracion_conformidad_tercero',
        'acciones_mejora',
        'metas_mitigacion',
        'meta_reduccion',
        'anio_meta',
        'anio_proyeccion_meta',
        'meta_alineada',
        'metodologias',
        'seguimiento_cumplimiento',
        'efecto_invernadero',
        'sumideros',
        'informacion_mensual',
        'diagrama_procesos',
        'areas_sumideros',
        'informacion_centralizada',
        'soportes_consumos',
        'informacion_anio',
        'estimaciones_consumos',
        'consumos_energeticos',
        'sustento_metodologico',
        'compartira_reporte',
        'toma_decisiones',
        'usuario_creacion_id',
        'empresa_id',
        'sede_id',
    ];

    /**
     * Obtiene el usuario que realiza el diligenciamiento de las preguntas.
     */
    public function usuarioCreacion()
    {
        return $this->belongsTo(User::class, 'usuario_creacion_id', 'id');
    }

    /**
     * Obtiene la empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Obtiene la sede de la empresa.
     */
    public function empresaSede()
    {
        return $this->belongsTo(EmpresaSede::class, 'sede_id', 'id');
    }
}
