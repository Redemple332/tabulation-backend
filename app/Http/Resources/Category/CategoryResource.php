<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'percentage' => $this->percentage,
            'min_score' => $this->min_score,
            'max_score' => $this->max_score,
            'order' => $this->order,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
