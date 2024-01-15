<?php

namespace App\Repository\Score;

use App\Models\Score;
use App\Repository\Base\BaseRepository;
use App\Repository\Score\ScoreRepositoryInterface;


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

}
