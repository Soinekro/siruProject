<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\OauthAccessTokens;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $users = User::included()
            ->filter()
            ->sort()
            ->getOrpaginate();
        return response()->json([
            'message' => 'Hello World',
            'users' => $users,
        ]);
    }
    public function register(Request $request)
    {
        try {
            //return auth()->user();
            $user = User::findOrFail(auth()->user()->id);
            if ($user->is_admin() && $user->is_active()) {
                $request->validate([
                    'name' => 'required|string',
                    'lastname' => 'required|string',
                    'dni' => 'required|numeric|digits:8|unique:user_siru',
                    'email' => 'required|string|email|unique:user_siru',
                    'enterprise_id' => 'required|numeric|exists:enterprise,id',
                    'role' => 'required',
                ]);
                $pass = fake()->password;//genera una contraseña aleatoria
                $request->merge([ //agrega los datos al request
                    'password' => Hash::make($pass),
                    'status' => User::ACTIVO,
                ]);
                $user = User::create($request->except('_token')); //crea el usuario

                return response()->json([ //retorna el usuario creado
                    'message' => 'Usuario registrado correctamente',
                    'user' => UserResource::make($user),
                    'password_default' => $pass,

                ], 201);
            } else {
                return response()->json([
                    'message' => 'no tiene autorizacion para realizar esta accion',
                    'user' => auth()->user(),
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
