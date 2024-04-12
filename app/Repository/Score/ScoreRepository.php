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
       return  $this->model->with(['judge', 'category', 'candidate' ])->filter()->scoreByCategory()->get();
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
