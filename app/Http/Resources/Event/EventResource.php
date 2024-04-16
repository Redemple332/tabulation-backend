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
            'icon' => env('TABULATION_URL').'/' .env('TABULATION_NAME').'/images/events/icon/'.$this->icon,
            'banner' => env('TABULATION_URL').'/' .env('TABULATION_NAME').'/images/events/banner/'.$this->banner,
            'current_category' => new CategoryResource($this->category),
            'next_category' => new CategoryResource($this->nextCategory),
            'description' => $this->description,
        ];
    }
}
