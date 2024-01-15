<?php

namespace App\Http\Resources\Event;

use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'date' => $this->date,
            'icon' => $this->icon,
            'banner' => $this->banner,
            'category' => new CategoryResource($this->category),
            'description' => $this->description,
        ];
    }
}
