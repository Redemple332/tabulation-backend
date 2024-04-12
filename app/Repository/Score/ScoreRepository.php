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
       return  $this->model->with(['judge', 'category', 'candidate' ])->scoreByCategory();
    }

    public function submitScoreJudge(array $data)
    {
        if (Auth::user()->isDoneVoting) {
            $this->errorReponse("Cannot submit score, voting is already done.");
        }

        $judgeId = $data['judge_id'] ?? null;
        $categoryId = $data['category_id'] ?? null;

        if (!Category::where('id', $categoryId)->active()->exists()) {
           $this->errorReponse("Category is not active.");
        }

        foreach ($data['scores'] as $score) {
            $this->model->create([
                 'judge_id' => $judgeId,
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
