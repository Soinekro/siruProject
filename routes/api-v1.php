<?php

use App\Http\Controllers\Api\Enterprises\RegisterController as EnterprisesRegisterController;
use App\Http\Controllers\Api\UbigeoController;
use App\Http\Controllers\Api\Users\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
Route::post('enterprise/register', [EnterprisesRegisterController::class, 'register'])->name('api-v1.enterprise.register');
Route::controller(UserController::class)->prefix('users')->group(function () {//<--- ruta ejemplo
    Route::get('/', 'index');
    /* Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete'); */
});
//Si quieres me dejas eso a mi y sigues avanzando en lo del token(?)
//no funciona con la instancia?

Route::controller(UbigeoController::class)->prefix('ubigeo')->group(function(){
    Route::get('departamentos', 'departmenst'); //esta en español
    Route::get('provinces/{id}','provinces');  //esta en ingles D:
    Route::get('distrito/{id}','distrits');
});
//Route::get('register', [RegisterController::class, 'register'])->name('api-v1.users.register');
//
