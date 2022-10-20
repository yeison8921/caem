<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaTemporal extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empresas_temporales';

    protected $fillable = [
        'nombre',
        'nit',
        'telefono',
        'codigo_ciiu_id',
        'sector_id',
        'empleado_id',
        'tamano_id',
        'departamento_id',
        'ciudad_id',
        'usuario_creacion_id',
        'nombre_sede',
    ];

    /**
     * Obtiene el sector de la empresa.
     */
    public function sector()
    {
        return $this->belongsTo(Parametro::class, 'sector_id', 'id');
    }

    /**
     * Obtiene la cantidad de empleados de la empresa.
     */
    public function empleado()
    {
        return $this->belongsTo(Parametro::class, 'empleado_id', 'id');
    }

    /**
     * Obtiene el tamaño de la empresa.
     */
    public function tamano()
    {
        return $this->belongsTo(Parametro::class, 'tamano_id', 'id');
    }

    /**
     * Obtiene el departamento de la empresa.
     */
    public function departamento()
    {
        return $this->belongsTo(Parametro::class, 'departamento_id', 'id');
    }

    /**
     * Obtiene la ciudad de la empresa.
     */
    public function ciudad()
    {
        return $this->belongsTo(Parametro::class, 'ciudad_id', 'id');
    }

    /**
     * Obtiene el convenio de la empresa.
     */
    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id', 'id');
    }

    /**
     * Obtiene las sedes de la empresa.
     */
    public function sedes()
    {
        return $this->hasMany(EmpresaSede::class, 'empresa_id', 'id');
    }

    /**
     * Obtiene el usuario que actualiza la empresa.
     */
    public function usuarioCreacion()
    {
        return $this->belongsTo(User::class, 'usuario_creacion_id', 'id');
    }
}
