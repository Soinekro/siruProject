<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    public function register(Request $request)
    {
        try{
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
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error creating user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
