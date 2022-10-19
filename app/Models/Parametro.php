<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametro extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo_parametro_id',
        'parametro_id',
    ];

    /**
     * Obtiene el parametro padre del parametro.
     */
    public function parametro()
    {
        return $this->belongsTo(Parametro::class, 'parametro_id', 'id');
    }
}
