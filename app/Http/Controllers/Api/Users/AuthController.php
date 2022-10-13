<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\Distrit;
use App\Models\Enterprise;
use App\Models\Province;
use App\Models\User;
use App\Traits\Token;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use Token;
    public function __construct()
    {
        $this->middleware('auth:api')->only('register', 'logout');
    }
    public function register(Request $request)
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            if ($user->is_admin() && $user->is_active()) {
                $request->validate([
                    'name' => 'required|string',
                    'lastname' => 'required|string',
                    'dni' => 'required|numeric|digits:8|unique:users',
                    'email' => 'required|string|email|unique:users',
                    'enterprise_id' => 'required|numeric|exists:enterprises,id',
                    'role' => 'required|string',
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

    public function login(Request $request)
    {
        //validar datos
        $request->validate([
            'dni' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('dni', $request->dni)->firstOrFail(); //verificamos si el usuario existe
        if (Hash::check($request->password, $user->password)) { //verificamos si la contraseña es correcta
            DB::select("CALL spLoginUser($user->id)"); //llamada a procedimiento almacenado para registrar el login
            $token = ($user->tokens()->count() > 0) ?  null : $this->getAccessToken(); //verificamos si el usuario tiene un token activo
            if ($token != null) { //si el token es diferente de null es porque el usuario no tiene un token activo
                return response()->json([
                    'message' => 'Usuario logueado correctamente',
                    'user' => UserResource::make($user),
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'],
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
        try {
            auth()->user();
            return response()->json([
                'message' => 'Usuario deslogueado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al desloguear usuario',
                'error' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function recoverPassword(Request $request)
    {
        request()->validate([
            'email' => 'required|email|exists:user_siru,email',
        ]);
        $user = User::where('email', $request->email)->firstOrFail();
        $pass = fake()->password;
        $user->password = Hash::make($pass);
        $user->pass_status = User::PASS_DEFAULT;
        //$user->update();
        //metodo de envio de email.
        Mail::send('emails.reset-password', ['user' => $user, 'password' => $pass], function ($message) use ($user) {
            $message
                ->to($user->email)
                ->subject('Recuperacion de contraseña');
        });
        //fin de metodo envio de email
        return response()->json([
            'message' => 'Contraseña actualizada correctamente',
            'password_default' => $pass,
        ], 200);
    }
}
