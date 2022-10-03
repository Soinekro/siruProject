<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ApiTrait;
    //protected $table = 'user_siru';
    const ACTIVO = 'active';
    const INACTIVO = 'inactive';
    const ADMIN = 'admin';
    const ENTERPRISE = 'enterprise';
    const EMPLOYE = 'employe';

    protected $allowIncluded = ['enterprise'];
    protected $allowFilter = ['id', 'name', 'email', 'role'];
    protected $allowSort = ['id', 'name', 'email', 'role'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'enterprise_id',
        'rol',
        'dni',
        'lastname',
        'email',
        'password',
        'status',
    ];
     protected $timestamp = false;
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

    public function enterprise()
    {
        return $this->hasOne(Enterprise::class);
    }

    public function is_admin()
    {
        return $this->rol == self::ADMIN;
    }

    public function is_active()
    {
        return $this->status == self::ACTIVO;
    }

    public function findForPassport($username)
    {
        return $this->where('dni', $username)->first();
    }

    public function tokens()
    {
        return $this->hasMany(OauthAccessTokens::class);
    }
}
