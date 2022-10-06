<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrit extends Model
{
    use HasFactory;
    protected $table = 'district';
    public $timestamps = false;
    protected $keyType = 'string';

    public function enterprises()
    {
        return $this->hasMany(Enterprise::class,'district_id','id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
