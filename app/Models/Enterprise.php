<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    use ApiTrait;

    protected $table = 'enterprise';
    public $timestamps = false;
    protected $guarded = [
        'id',
    ];
    protected $allowIncluded = ['users'];
    protected $allowFilter = ['id', 'name', 'social_reason', 'ruc', 'address', 'phone', 'email'];
    protected $allowSort = ['id', 'name', 'social_reason', 'ruc', 'address', 'phone', 'email'];

    public function users()
    {
        return $this->hasMany(User::class,'enterprise_id','id');
    }

    public function getRouteKeyName()
    {
        return 'ruc';
    }
}
