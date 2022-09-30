<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Enterprise extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use ApiTrait;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $allowIncluded = ['user'];
    protected $allowFilter = ['id', 'name', 'social_reason', 'ruc', 'address', 'phone', 'email', 'user_id'];
    protected $allowSort = ['id', 'name', 'social_reason', 'ruc', 'address', 'phone', 'email', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
