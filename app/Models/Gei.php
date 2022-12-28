<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gei extends Model
{
    use HasFactory;

    protected $fillable = [
        'gei',
        'ar5pcg_gwp',
        'ar4pcg_gwp',
        'srpcg_gwp',
    ];
}
