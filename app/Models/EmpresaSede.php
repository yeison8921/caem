<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaSede extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'empresa_id',
        'departamento_id',
        'ciudad_id',
        'direccion',
    ];

    /**
     * Obtiene la empresa.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Obtiene el departamento de la sede.
     */
    public function departamento()
    {
        return $this->belongsTo(Parametro::class, 'departamento_id', 'id');
    }

    /**
     * Obtiene la ciudad de la sede.
     */
    public function ciudad()
    {
        return $this->belongsTo(Parametro::class, 'ciudad_id', 'id');
    }

    /**
     * Obtiene los empresarios de la sede.
     */
    public function empresarios()
    {
        return $this->hasMany(User::class, 'sede_id', 'id');
    }
}
