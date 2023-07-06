<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformacionEmpresa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
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
        'metodologia',
        'otra_metodologia',
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
        'unidades_producidas',
        'tipo_unidad',
        'anio_inicio',
        'mes_inicio',
        'estado',
        'fecha_aprobacion',
        'esta_aprobado',
        'usuario_creacion_id',
        'empresa_id',
        'sede_id',
    ];
    protected $casts = [
        'esta_aprobado' => 'boolean',
    ];

    protected $appends = ['periodo'];
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

    public function getPeriodoAttribute()
    {
        $array_meses = [
            "ENERO",
            "FEBRERO",
            "MARZO",
            "ABRIL",
            "MAYO",
            "JUNIO",
            "JULIO",
            "AGOSTO",
            "SEPTIEMBRE",
            "OCTUBRE",
            "NOVIEMBRE",
            "DICIEMBRE",
        ];

        if (!empty($this->anio_inicio) && !empty($this->mes_inicio)) {
            $fecha_base = new DateTime($this->anio_inicio . '-' . $this->mes_inicio . '-01 00:00');

            $future = new DateTime();
            $future->setDate($fecha_base->format('Y'), $fecha_base->format('n') + 11, 1);

            $mes_fecha_base = $array_meses[$fecha_base->format('n') - 1];

            $mes_futuro = $array_meses[$future->format('n') - 1];
            $anio_futuro = $future->format('Y');

            return $mes_fecha_base . ' ' . $this->anio_inicio . ' a ' . $mes_futuro . ' ' . $anio_futuro;
        } else {
            return '';
        }
    }
}
