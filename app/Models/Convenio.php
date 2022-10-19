<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre_convenio',
        'nombre_entidad',
        'codigo',
        'logo_url',
        'texto_legal',
        'usuario_actualizo_id',
    ];

    /**
     * Obtiene el usuario que actualiza el convenio.
     */
    public function usuarioActualizo()
    {
        return $this->belongsTo(User::class, 'usuario_actualizo_id', 'id');
    }
    
    /**
     * Obtiene los emails asociados al convenio.
     */
    public function emails()
    {
        return $this->hasMany(ConvenioEmail::class, 'convenio_id', 'id');
    }


}
