<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Distrit;
use App\Models\Province;
use Illuminate\Http\Request;

class UbigeoController extends Controller
{
    public function departmenst()
    {
        $departments = Department::all();
        return response()->json([
            'message' => 'listado de departamentos',
            'departments'=>$departments,
        ],201);
    }

    public function provinces($id){
        $provinces = Province::where('department_id',$id)->get();
        return response()->json([
            'message' => 'listado de provincias',
            'provincias' => $provinces,
        ]);
    }
    public function distrits($id){
        $distrits = Distrit::where('province_id', $id)->get();
        //Acuerdate de borrar las carpetas (Department,Distrit,Province) y el controlador
        return response()->json([
            'message' => 'Listado de distritos',
            'distritos'=> $distrits,
        ]);

    }
}
//GET|HEAD  api-v1/ubigeo/departamentos
//GET|HEAD  api-v1/ubigeo/provincias/{id}
//no veo distrito
//ACUERDATE DEL REPORTE DEL MES
