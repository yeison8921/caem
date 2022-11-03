<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'nit',
        'telefono',
        'codigo_ciiu_id',
        'sector_id',
        'empleado_id',
        'tamano_id',
        'convenio_id',
        'usuario_actualizo_id',
    ];

    /**
     * Obtiene el código ciiu de la empresa.
     */
    public function codigo()
    {
        return $this->belongsTo(Parametro::class, 'codigo_ciiu_id', 'id');
    }

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
     * Obtiene las sedes de la empresa.
     */
    public function sedes()
    {
        return $this->hasMany(EmpresaSede::class);
    }

    /**
     * Obtiene el usuario que actualiza la empresa.
     */
    public function usuarioActualizo()
    {
        return $this->belongsTo(User::class, 'usuario_actualizo_id', 'id');
    }

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class);
    }
}
