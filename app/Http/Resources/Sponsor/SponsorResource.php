<?php

namespace App\Http\Resources\Sponsor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorResource extends JsonResource
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
            'name' => $this->name,
            'position' => $this->position,
            'image' => env('TABULATION_URL').'/' .env('TABULATION_NAME').'/images/sponsors/'.$this->image,
            'description' => $this->description,
        ];
    }
}
