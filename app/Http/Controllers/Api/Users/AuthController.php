<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('register');
    }
    public function register(Request $request)
    {
        try {
            if (auth()->user()->user->is_admin() && auth()->user()->user->is_active()) {
                $request->validate([
                    'name' => 'required|string',
                    'father_lastname' => 'required|string',
                    'mother_lastname' => 'required|string',
                    'birthdate' => 'required|date',
                    'dni' => 'required|numeric|digits:8|unique:users',
                    'email' => 'required|string|email|unique:users',
                ]);

                $user = User::create($request->all());

                return response()->json([
                    'message' => 'User created successfully',
                    'user' => $user,
                ], 201);
            }

            return response()->json([
                'message' => 'You are not authorized to register users',
                'user' => auth()->user()->user,
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            //return Enterprise::all();
            $enterprise = Enterprise::where('ruc', $request->ruc)->firstOrFail();

            if (Hash::check($request->password, $enterprise->password)) {
                return response()->json([
                    'message' => 'User logged in successfully',
                    'data' => EnterpriseResource::make($enterprise),
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error en logging',
                    'error' => 'Incorrect password',
                ], 401);
            }
        } catch (\Exception $e) {
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
            'Accept'=>'aplication/json',
        ])->get('http://siru.test/oauth/tokens',[
            //'grant_type'=>'refresh_token',
            //'refresh_token'=>auth()->user()->accessToken->refresh_token,
            //'client_id' => config('services.codersfree.client_id'),
            //'client_secret' => config('services.codersfree.client_secret'),
        ]);

        return $response->json();
    }
}
