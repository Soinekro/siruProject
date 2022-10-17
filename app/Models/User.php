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
    const ACTIVO = 1;
    const INACTIVO = 0;
    const SUPER_ADMIN = 'Super Administrador';
    const ADMIN = 'Administrador';
    const USER = 'Usuario';

    const PASS_DEFAULT = 0;
    const PASS_CHANGED = 1;

    protected $table = 'user_siru';
    protected $allowIncluded = ['enterprise'];
    protected $allowFilter = ['id', 'name', 'email', 'role'];
    protected $allowSort = ['id', 'name', 'email', 'role'];

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'enterprise_id',
        'role',
        'name',
        'lastname',
        'email',
        'dni',
        'password',
        'telephone',
        'ruc_personal',
        'status',
        'email_verified',
        'pass_status'
    ];
     protected $timestamp = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /* protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }

    public function is_admin()
    {
        return $this->role == self::SUPER_ADMIN;
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

    public function name_complete()
    {
        return $this->name . ' ' . $this->lastname;
    }
}
