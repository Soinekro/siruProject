<?php

use App\Http\Controllers\Api\Enterprises\RegisterController as EnterprisesRegisterController;
use App\Http\Controllers\Api\Users\AuthController;
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

//Route::get('register', [RegisterController::class, 'register'])->name('api-v1.users.register');
