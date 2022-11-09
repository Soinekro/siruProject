<?php

namespace App\Http\Controllers\Api\Enterprises;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnterpriseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'superadmin']);
    }

    public function list()
    {
        $enterprises = Enterprise::included()
            ->filter()
            ->sort()
            ->getOrpaginate();
        return EnterpriseResource::collection($enterprises);
    }
    public function register(Request $request)
    {
            $user = User::find(auth()->user()->id);
            if ($user->is_admin() && $user->is_active()) {
                $request->validate([
                    'social_reason' => 'required|string',
                    'ruc' => 'required|numeric|digits:11|unique:enterprise',
                    'user_sol' => 'required|string',
                    'password_sol' => 'required|string',
                    'logo' => 'required|image',
                    'certificate' => 'required|file',
                    'certificate_password' => 'required|string',
                    'distrit_id' => 'required|numeric|digits:6|exists:district,id',
                ]);
                //procedimiento para registrar empresa
                DB::select('call spInsertEnterprise(?,?,?,?,?,?,?)', [
                    $request->distrit_id,
                    $request->ruc,
                    $request->address,
                    $request->social_reason,
                    $request->user_sol,
                    $request->password_sol,
                    $request->certificate_password,
                ]);
                $enterprise = Enterprise::where('ruc', $request->ruc)->first();
                $request->file('logo')->storeAs('public/enterprises/' . $request->ruc, 'logo.png');
                $request->file('certificate')->storeAs('enterprises/' . $request->ruc, 'certificate.pfx');
                return response()->json([
                    'message' => 'empresa creada satisfactoriamente',
                    'enterprise' => EnterpriseResource::make($enterprise),
                ], 201);
            }
            return response()->json([
                'message' => 'usted no tiene autorizacion para realizar esta accion',
                'user' => auth()->user()->user,
            ], 401);
    }
    public function update(Request $request,$ruc)
    {
            //return Enterprise::all();
            $enterprise = Enterprise::where('ruc',$ruc)->first();
            $user = User::find(auth()->user()->id);
            if ($user->is_admin() && $user->is_active()) {
                $request->validate([
                    'social_reason' => 'required|string',
                    'ruc' => 'required|numeric|digits:11|unique:enterprise,ruc,' . $enterprise->id,
                    'user_sol' => 'required|string',
                    'password_sol' => 'required|string',
                    'logo' => 'image',
                    'certificate' => 'file',
                    'certificate_password' => 'required|string',
                ]);
                //procedimiento para editar empresa
                DB::select('call spUpdateEnterprise(?,?,?,?,?,?,?)', [
                    $enterprise->id,
                    $request->ruc,
                    $request->address,
                    $request->social_reason,
                    $request->user_sol,
                    $request->password_sol,
                    $request->certificate_password,
                ]);
                $enterprise = Enterprise::where('ruc', $request->ruc)->first();
                return $enterprise;
                if ($request->hasFile('logo')) {
                    $request->file('logo')->storeAs('public/enterprises/' . $request->ruc, 'logo.png');
                }
                if ($request->hasFile('certificate')) {
                    $request->file('certificate')->storeAs('enterprises/' . $request->ruc, 'certificate.pfx');
                }
                return response()->json([
                    'message' => 'empresa editada satisfactoriamente',
                    'enterprise' => EnterpriseResource::make($enterprise),
                ], 201);
            }
            return response()->json([
                'message' => 'usted no tiene autorizacion para realizar esta accion',
                'user' => auth()->user()->user,
            ], 401);
    }

    public function delete($ruc){
        $enterprise = Enterprise::where('ruc',$ruc)->first();
        $user = User::find(auth()->user()->id);
        if ($user->is_admin() && $user->is_active()) {
            $enterprise->delete();
            return response()->json([
                'message' => 'empresa eliminada satisfactoriamente',
                'enterprise' => EnterpriseResource::make($enterprise),
            ], 201);
        }
        return response()->json([
            'message' => 'usted no tiene autorizacion para realizar esta accion',
            'user' => auth()->user()->user,
        ], 401);
    }
    public function revoke($ruc)
    {
        $enterprise = Enterprise::where('ruc', $ruc)->first();
        $user = User::find(auth()->user()->id);
        return $user->enterprise;
        if ($user->is_admin() && $user->is_active()) {
            foreach ($enterprise->users as $user) {
                $user->update([
                    'status' => 0,
                ]);
            }
            return response()->json([
                'message' => 'empresa revocada satisfactoriamente',
                'enterprise' => EnterpriseResource::make($enterprise),
            ], 201);
        }
        return response()->json([
            'message' => 'usted no tiene autorizacion para realizar esta accion',
            'user' => auth()->user()->user,
        ], 401);
    }
}
