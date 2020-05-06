<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'users',
            'id' => (string) $this->id,
            'attributes' => [
                'name' => Str::ucfirst($this->name),
                'email' => $this->email,
            ],
            'relationships' => new UserRelationshipResource($this),
            'links' => [
                'self' => route('users.show', ['user'=>$this->id]),
            ]
        ];
    }
}
