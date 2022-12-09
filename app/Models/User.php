<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const STATUS_UNDEFINED = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;
    public const TYPE_ADMIN = 1;
    public const TYPE_EMPRESARIO = 2;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'cargo',
        'estado', // 0 sin aprovar, 1 aprobado, 2 rechazado
        'rol_id',
        'empresa_id',
        'sede_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $password
     */
    public function setPasswordAttribute($password): void
    {
        // If password was accidentally passed in already hashed, try not to double hash it
        // Note: Password Histories are logged from the \App\Domains\Auth\Observer\UserObserver class
        $this->attributes['password'] =
            (strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
            (strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password)) ?
            $password :
            Hash::make($password);
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
}
