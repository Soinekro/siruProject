<?php

namespace App\Models;

use App\Traits\ApiTrait;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,ApiTrait;

    const ACTIVO = 1;
    const INACTIVO = 0;
    protected $table = 'category';
    protected $allowIncluded = ['products'];
    protected $allowFilter = ['id','name','slug'];
    protected $allowSort = ['id','name','slug'];

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
/*
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower($value),
        );
    } */

}
