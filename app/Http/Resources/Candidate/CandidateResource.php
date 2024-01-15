<?php

namespace App\Http\Resources\Candidate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
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
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'no' => $this->no,
            'gender' => $this->gender,
            'age' => $this->age,
            'image' => $this->image,
            'contact' => $this->contact,
            'address' => $this->address,
            'status' => $this->status,
            'description' => $this->description,
        ];

    }
}
