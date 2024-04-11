<?php

namespace App\Repository\Score;

use App\Models\Category;
use App\Models\Score;
use App\Models\User;
use App\Repository\Base\BaseRepository;
use App\Repository\Score\ScoreRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

    public function submitScoreJudge(array $data)
    {
        $judge_id = $data['judge_id'];
        $category_id = $data['category_id'];

        if(!Auth::user()->isDoneVoting)
        {
            foreach ($data['scores'] as $score) {
                $this->model->create([
                     'judge_id' => $judge_id,
                     'category_id' => $category_id,
                     'candidate_id' => $score['candidate_id'],
                     'score' => $score['score'],
                     'description' => $score['description']
                 ]);
             }
             return "Submitted!";
        }
        return "Can't Submit Score!";

    }
}
