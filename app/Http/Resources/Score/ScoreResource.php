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
            'id' => $this->id,
            'judge_id' => $this->judge_id,
            'candidate_id' => $this->candidate_id,
            'category_id' => $this->category_id,
            'judge_name' => $this->judge->full_name,
            'judge_no' => $this->judge->judge_no,
            'candidate_no' => $this->candidate->no,
            'candidate_name' => $this->candidate->first_name . ' ' . $this->candidate->last_name,
            'category' => $this->category->name,
            'score' => $this->score,
        ];
    }
}
