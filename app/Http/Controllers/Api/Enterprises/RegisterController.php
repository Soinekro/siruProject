<?php

namespace App\Http\Controllers\Api\Enterprises;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Models\Enterprise;
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
            if (auth()->user()->user->is_admin() && auth()->user()->user->is_active()) {
                $request->validate([
                    'name' => 'required|string',
                    'ruc' => 'required|numeric|digits:11|unique:enterprises',
                    'password' => 'required|string',
                    'user_sol' => 'required|string',
                    'password_sol' => 'required|string',
                    'user_id' => 'required|numeric|unique:enterprises',
                ]);
                $request['password'] = Hash::make($request->password);
                $enterprise = Enterprise::create($request->all());

                return response()->json([
                    'message' => 'enterprise created successfully',
                    'enterprise' => EnterpriseResource::make($enterprise),
                ], 201);
            }
            return response()->json([
                'message' => 'You are not authorized to register enterprises',
                'user' => auth()->user()->user,
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating enterprise',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
