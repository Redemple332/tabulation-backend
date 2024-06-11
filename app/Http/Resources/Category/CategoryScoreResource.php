<?php

namespace App\Http\Resources\Category;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $scores = $this->scores;

        // Group scores by candidate
        $candidatesScores = $scores->groupBy('candidate_id');

        // Calculate total and average scores for each candidate
        $candidates = $candidatesScores->map(function ($scores, $candidateId) {
            $candidate = $scores->first()->candidate;
            $total = $scores->sum('score');
            $average = $scores->avg('score');
            return [
                'candidate_no' => $candidate->no,
                'total' => $total,
                'average' => $average,
                'scores' => $scores
            ];
        });

        // Rank candidates by average score and sort by candidate number
        $rankedCandidates = $candidates->sortBy('no')->values();
        $judges = User::select('judge_no', 'first_name', 'last_name')->where('role_id', 'b9612992-1e02-4572-b618-6bcd60d651ac')->get();

        // Assign ranks and structure the judge scores
        $rankedCandidates = $rankedCandidates->map(function ($candidate, $index) use ($rankedCandidates, $judges) {
            $judgeScores = $candidate['scores']->map(function ($score) {
                return [
                    'judge_no' => $score->judge->judge_no,
                    'judge_score' => $score->score
                ];
            });

            // Ensure all judges are accounted for, marking "Not Already Voted" for missing scores
            $allJudgeNumbers = range(1, $judges->count()); // Assuming there are 5 judges

            $judgeScores = collect($allJudgeNumbers)->map(function ($judgeNo) use ($judgeScores) {
                $judgeScore = $judgeScores->firstWhere('judge_no', $judgeNo);
                return [
                    'judge_no' => $judgeNo,
                    'judge_score' => $judgeScore['judge_score'] ?? 'Not Already Voted'
                ];
            });

            return [
                'candidate_no' => $candidate['candidate_no'],
                'average' => round($candidate['average'], 2),
                'rank' => $rankedCandidates->where('average', '>=', $candidate['average'])->count(),
                'judge_score' => $judges
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'header' => $judges,
            'judges_score' => $rankedCandidates
        ];
    }
}


