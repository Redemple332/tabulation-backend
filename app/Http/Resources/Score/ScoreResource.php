<?php

namespace App\Http\Resources\Score;

use App\Http\Resources\Candidate\CandidateResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'judge' => new UserResource($this->judge),
            'candidate' => new CandidateResource($this->candidate),
            'category' => new CategoryResource($this->category),
            // 'score' => $this->score,
            // 'description' => $this->description,
        ];
    }
}
