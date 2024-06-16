<?php

namespace App\Http\Resources\Score;

use App\Http\Resources\Candidate\CandidateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreOverAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'average_score' => number_format($this->average_score, 2),
            'candidate_id' => new CandidateResource($this->candidate),
        ];
    }
}
