<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait Token{

    public function getAccessToken(){
        $response = Http::withHeaders([
            'Accept'=>'aplication/json',
        ])->post('http://siru.test/oauth/token',[
            'grant_type'=>'password',
            'client_id' => config('services.siru.client_id'),
            'client_secret' => config('services.siru.client_secret'),
            'username' =>  request('dni'),
            'password'  => request('password'),
        ]);

        return $response->json();
    }

    public function generatePassword(){
        $characters = '$%&$@)(0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < 8; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }
}
