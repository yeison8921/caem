<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConvenioEmail extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'email',
        'nit',
        'convenio_id',
    ];

    /**
     * Obtiene el convenio
     */
    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id', 'id');
    }
}