<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory,ApiTrait;

    protected $table = 'product';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public static function call_PA_CreateProduct(){
        $product = DB::select("call spInsertProduct(?,?,?,?,?,?,?,?,?,?)",[
            request('category_id'),
            request('type_id'),
            request('serie_prod'),
            request('nombre_prod'),
            request('descripcion_prod'),
            request('pr'),
            request('stock_prod'),
            request('igv_status'),
            request('unidad_medida'),
            request('add_day'),
        ]);

        return $product;
    }

}
