<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait Token{

    public function getAccessToken(){
        $response = Http::withHeaders([
            'Accept'=>'aplication/json',
        ])->post('https://facturacion.sirusoluciones.com/oauth/token',[
            'grant_type'=>'password',
            'client_id' => config('services.siru.client_id'),
            'client_secret' => config('services.siru.client_secret'),
            'username' =>  request('dni'),
            'password'  => request('password'),
        ]);

        return $response->json();
    }

    public function resolveAuthorization(){
        $response = Http::withHeaders([
            'Accept'=>'aplication/json',
        ])->post('https://facturacion.sirusoluciones.com/oauth/token',[
            'grant_type'=>'refresh_token',
            'refresh_token'=>request('refresh_token'),
            'client_id' => config('services.siru.client_id'),
            'client_secret' => config('services.siru.client_secret'),
        ]);

        return $response->json();
    }
}
