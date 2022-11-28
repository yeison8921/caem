<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'informacion_empresa_id',
        'empresa_id',
        'sede_id',
    ];

    /**
     * Obtiene los subprocesos asociados al proceso.
     */
    public function subprocesos()
    {
        return $this->hasMany(Subproceso::class);
    }
}
