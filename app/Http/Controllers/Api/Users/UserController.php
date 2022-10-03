<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\OauthAccessTokens;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $user = auth()->user()->tokens;
        $users = User::with('tokens')->get();
        $tokens = OauthAccessTokens::all();
        return response()->json([
            'message' => 'Hello World',
            'user' => $user,
        ]);
    }
}
