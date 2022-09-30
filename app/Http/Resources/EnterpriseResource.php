<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnterpriseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ruc' => $this->ruc,
            'user_sol' => $this->user_sol,
            'password_sol' => $this->password_sol,
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
