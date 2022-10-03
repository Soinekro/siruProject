<?php

namespace App\Http\Controllers\Api\Enterprises;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
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
                    'social_reason' => 'required|string',
                    'ruc' => 'required|numeric|digits:11|unique:enterprises',
                    'user_sol' => 'required|string',
                    'password_sol' => 'required|string',
                    'logo' => 'required|image',
                    'certificate' => 'required|file',
                    'certificate_password' => 'required|string',
                    'distrit_id' => 'required|numeric|exists:distrits,id',
                ]);
                $enterprise = Enterprise::create($request->except('_token'));

                return response()->json([
                    'message' => 'empresa creada satisfactoriamente',
                    'enterprise' => EnterpriseResource::make($enterprise),
                ], 201);
            }
            return response()->json([
                'message' => 'usted no tiene autorizacion para realizar esta accion',
                'user' => auth()->user()->user,
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar empresa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
