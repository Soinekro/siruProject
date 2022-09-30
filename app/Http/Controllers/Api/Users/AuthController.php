<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Http\Resources\UserResource;
use App\Models\Enterprise;
use App\Models\User;
use App\Traits\Token;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    use Token;
    public function __construct()
    {
        $this->middleware('auth:api')->only('register');
    }
    public function register(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            if ($user->is_admin() && $user->is_active()) {
                $request->validate([
                    'name' => 'required|string',
                    'lastname' => 'required|string',
                    'dni' => 'required|numeric|digits:8|unique:users',
                    'email' => 'required|string|email|unique:users',
                    'enterprise_id' => 'required|numeric|exists:enterprises,id',
                    'rol' => 'required|string|in:admin,enterprise,employe',
                ]);
                $pass = fake()->password;;
                $request->merge([
                    'password' => Hash::make($pass),
                    'status' => User::ACTIVO,
                ]);
                $user = User::create($request->except('_token'));

                return response()->json([
                    'message' => 'Usuario registrado correctamente',
                    'user' => UserResource::make($user),
                    'password_default' => $pass,

                ], 201);
            } else {
                return response()->json([
                    'message' => 'no tiene autorizacion para realizar esta accion',
                    'user' => auth()->user()->user,
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'dni' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::where('dni', $request->dni)->firstOrFail();

            if (Hash::check($request->password, $user->password)) {
                $token = $this->getAccessToken();
                return response()->json([
                    'message' => 'User logged in successfully',
                    'data' => UserResource::make($user),
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'],
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error en logging',
                    'error' => 'Incorrect password',
                ], 401);
            }
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                'message' => 'las credenciales no son correctas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function tokens()
    {
        $response = Http::withHeaders([
            'Accept' => 'aplication/json',
        ])->get('http://siru.test/oauth/tokens', [
            //'grant_type'=>'refresh_token',
            //'refresh_token'=>auth()->user()->accessToken->refresh_token,
            //'client_id' => config('services.codersfree.client_id'),
            //'client_secret' => config('services.codersfree.client_secret'),
        ]);

        return $response->json();
    }
}
