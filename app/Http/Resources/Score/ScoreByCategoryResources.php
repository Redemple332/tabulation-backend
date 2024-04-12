<?php

namespace App\Http\Resources\Score;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreByCategoryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'candidate_id' => $this->candidate->id,
            'candidate_name' => $this->candidate->full_name,
            'candidate_no' => $this->candidate->no,
            'category_id' => $this->category->id,
            'category_name' => $this->category->name,
            'average_score' => number_format($this->average_score, 2)
        ];
    }
}
