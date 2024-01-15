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
            'candidate_limit' => $this->candidate_limit,
            'min_score' => $this->min_score,
            'max_score' => $this->max_score,
            'order' => $this->order,
            'isCurrent' => $this->isCurrent,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
