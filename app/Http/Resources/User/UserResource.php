<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'contact' => $this->contact,
            'address' => $this->address,
            'email' => $this->email,
            'judge_no' => $this->judge_no,
            'is_active' => $this->is_active,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'role_id' => $this->role_id,
            'is_active' => $this->is_active,                                                                                                                                                                                                                
            'role' => new RoleResource($this->role),
        ];
    }
}
