<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $keyType = 'string';
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany(Distrit::class, 'province_id', 'id');
    }
}
