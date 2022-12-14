<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use App\Traits\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use Token;
    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'recoverPassword');
    }

    public function refresh(Request $request)
    {
        $response = $this->resolveAuthorization();
        if (isset($response['error'])) {
            return response()->json([
                'message' => $response['message'],
            ], 401);
        }
        return response()->json([
            'message' => 'sesion renovada',
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'],
        ], 200);
    }
    public function login(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('dni', $request->dni)->firstOrFail(); //verificamos si el usuario existe
        if (Hash::check($request->password, $user->password) && $user->is_active()) { //verificamos si la contraseña es correcta
            $token = ($user->tokens()->where('revoked',0)->count() > 0) ?  null : $this->getAccessToken(); //verificamos si el usuario tiene un token activo
            if ($token != null) { //si el token es diferente de null es porque el usuario no tiene un token activo
                DB::select("CALL spLoginUser($user->id)"); //llamada a procedimiento almacenado para registrar el login del usuario
                return response()->json([
                    'message' => 'Usuario logueado correctamente',
                    'user' => UserResource::make($user),
                    'token' => $token,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'El usuario ya tiene un token activo',
                    'user' => UserResource::make($user),
                ], 203);
            }
        } else {
            return response()->json([
                'message' => 'Error en logging',
                'error' => 'usuario o contraseña incorrectos',
            ], 401);
        }
    }

    public function logout()
    {
        $user = User::findorFail(auth()->user()->id);
        $user->tokens()->where('revoked', 0)->update(['revoked' => 1]);
        return response()->json([
            'message' => 'sesion cerrada',
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);
        $user = User::findOrFail(auth()->user()->id);
        $pass = Hash::make($request->password);
        Mail::to($user->email)->send(new ResetPasswordEmail($user, $request->password));
        if (Hash::check($request->old_password, $user->password) && $user->is_active()) {
            DB::select("CALL spUpdatePass('$user->dni','$pass')");
            return response()->json([
                'message' => 'Contraseña cambiada correctamente',
                'user' => UserResource::make($user),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error al cambiar contraseña',
                'error' => 'La contraseña actual no es correcta',
            ], 401);
        }
    }
    public function recoverPassword(Request $request)
    {
        request()->validate([
            'email' => 'required|email|exists:user_siru,email',
        ]);
        $user = User::where('email', $request->email)->firstOrFail();
        $pass = fake()->password;
        $passwordhash = Hash::make($pass);
        DB::select("CALL spUpdatePass('$user->dni','$passwordhash')");
        foreach ($user->tokens->where('revoked', 0) as $token) {
            $token->update([
                'revoked' => true,
            ]);
        }
        //metodo de envio de email.
        Mail::to($user->email)->send(new ResetPasswordEmail($user, $pass));
        //fin de metodo envio de email
        return response()->json([
            'message' => 'Contraseña actualizada correctamente',
        ], 200);
    }
}
