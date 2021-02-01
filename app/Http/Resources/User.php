<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class User
 * @package App\Http\Resources
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $username
 * @property string $email
 */
class User extends JsonResource
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
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'edit_url' => route('users.edit', $this->uuid),
            'destroy_url' => route('users.destroy', $this->uuid),
        ];
    }
}
