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
            'ruc' => $this->ruc,
            'social_reason' => $this->social_reason,
            'address' => $this->address,
            'user_sol' => $this->user_sol,
            'certificate_pass' => $this->certificate_pass,
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
