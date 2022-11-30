<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subproceso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'proceso_id',
        'empresa_id',
        'sede_id',
    ];

    /**
     * Obtiene las fuentes de emision asociados al subproceso.
     */
    public function fuentesEmision()
    {
        return $this->hasMany(FuenteEmision::class);
    }

    /**
     * Obtiene el proceso del subproceso
     */
    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }
}
