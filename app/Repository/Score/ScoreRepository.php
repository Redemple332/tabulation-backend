<?php

namespace App\Repository\Score;

use App\Models\Category;
use App\Models\Score;
use App\Models\User;
use App\Repository\Base\BaseRepository;
use App\Repository\Score\ScoreRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ScoreRepository extends BaseRepository implements ScoreRepositoryInterface
{

    /**
     * Score Repository constructor.
     *
     * @param Score $model
     */
    public function __construct(Score $model)
    {
        parent::__construct($model);
    }

    public function getScoreByCategory()
    {
       return  $this->model->with(['judge', 'category', 'candidate' ])->filter()->scoreByCategory()->get();
    }


    public function getOverAll()
    {
        $categoryIds = request('category_ids');

        $subQuery = DB::table('scores')
            ->select('candidate_id', 'category_id', DB::raw('AVG(score) as avg_score'))
            ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->groupBy('candidate_id', 'category_id');

        $finalScores = DB::table(DB::raw("({$subQuery->toSql()}) as avg_scores"))
            ->mergeBindings($subQuery)
            ->join('categories as c', 'avg_scores.category_id', '=', 'c.id')
            ->join('candidates as cand', 'avg_scores.candidate_id', '=', 'cand.id')
            ->select(
                DB::raw("CONCAT(cand.first_name, ' ', cand.last_name) as candidate_name"),
                'cand.no',
                'c.name as category_name',
                'c.percentage',
                DB::raw('ROUND(avg_scores.avg_score, 2) as avg_per_category'),
                DB::raw('ROUND(avg_scores.avg_score * (c.percentage / 100), 2) as weighted_score')
            )
            ->orderBy('cand.no')
            ->orderBy('c.name')
            ->get();

        // ✅ Group, compute totals, and sort by final score
        $totals = collect($finalScores)
            ->groupBy('candidate_name')
            ->map(function ($rows) {
                return [
                    'candidate_no' => $rows->first()->no,
                    'candidate_name' => $rows->first()->candidate_name,
                    'final_score' => round($rows->sum('weighted_score'), 2),
                    'categories' => $rows->map(function ($r) {
                        return [
                            'category' => $r->category_name,
                            'percentage' => $r->percentage,
                            'avg_per_category' => $r->avg_per_category,
                            'weighted_score' => $r->weighted_score,
                        ];
                    })->values()
                ];
            })
            ->sortByDesc('final_score')
            ->values();

        $rankedTotals = [];
        $previousScore = null;
        $rank = 0;
        $displayRank = 0;

        foreach ($totals as $item) {
            $displayRank++;

            if ($previousScore === null || $item['final_score'] < $previousScore) {
                $rank = $displayRank;
            }

            $item['rank'] = $rank;
            $rankedTotals[] = $item;
            $previousScore = $item['final_score'];
        }

        return collect($rankedTotals);


      // return  $this->model->with(['judge', 'category', 'candidate' ])->filter()->groupByCandidate()->get();
    }

    public function submitScoreJudge(array $data)
    {

        $categoryId = $data['category_id'] ?? null;

        if (!Category::where('id', $categoryId)->active()->exists()) {
           $this->errorReponse("Category is not active.");
        }
        if ($this->model->JudgeScore($categoryId)->count() > 0) {
            $this->errorReponse("Cannot submit score, voting is already done.");
        }

        foreach ($data['scores'] as $score) {
            $this->model->create([
                 'judge_id' => Auth::id(),
                 'category_id' => $categoryId,
                 'candidate_id' => $score['candidate_id'],
                 'score' => $score['score'],
                 'description' => $score['description']
             ]);
        }
        return $data;
    }

    public function errorReponse($message)
    {
        throw ValidationException::withMessages([
            'record_errors' => $message
        ]);
    }

}
