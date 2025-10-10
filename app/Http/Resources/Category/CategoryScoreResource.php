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

        // Get all judges
        $judges = User::select('judge_no', 'first_name', 'last_name')
            ->where('role_id', 'b9612992-1e02-4572-b618-6bcd60d651ac')
            ->get();

        // 🧩 DENSE RANKING FIX (1, 1, 2, 3, …)
        $sorted = $candidates->sortByDesc('average')->values();
        $rank = 0;
        $lastAverage = null;
        $displayRank = 0;

        $rankedCandidates = $sorted->map(function ($candidate) use (&$rank, &$lastAverage, &$displayRank) {
            $rank++;
            if ($candidate['average'] !== $lastAverage) {
                $displayRank++;
            }
            $lastAverage = $candidate['average'];
            return array_merge($candidate, ['rank' => $displayRank]);
        });

        // Build final candidate score data
        $rankedCandidates = $rankedCandidates->map(function ($candidate) {
            $judgeScores = $candidate['scores']->map(function ($score) {
                return [
                    'judge_no' => $score->judge->judge_no,
                    'judge_score' => $score->score
                ];
            });

            // Ensure all judges are accounted for (mark missing as "Not Already Voted")
            $judgeCount = User::where('role_id', 'b9612992-1e02-4572-b618-6bcd60d651ac')->count();
            $allJudgeNumbers = range(1, $judgeCount);

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
                'rank' => $candidate['rank'],
                'judge_score' => $judgeScores
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'headers' => $judges,
            'judges_score' => $rankedCandidates
        ];
    }
}


