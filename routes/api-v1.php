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
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('changePass', 'changePassword');
    Route::post('recoverPass', 'recoverPassword');
});
Route::post('enterprise/register', [EnterprisesRegisterController::class, 'register'])->name('api-v1.enterprise.register');
Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'index');
    Route::post('register', 'register');
    /* Route::get('show/{id}', 'show');
    Route::post('store', 'store');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete'); */
});

/* ESTARE EN REUNIONNNNNNNNNNN */
Route::controller(UbigeoController::class)->prefix('ubigeo')->group(function(){
    Route::get('departamentos', 'departmenst'); //esta en español
    Route::get('provincias/{id}','provinces');  //esta en español
    Route::get('distritos/{id}','distrits');
});
//Route::get('register', [RegisterController::class, 'register'])->name('api-v1.users.register');
//

