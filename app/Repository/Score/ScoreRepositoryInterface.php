<?php

namespace App\Repository\Score;

use App\Repository\Base\BaseRepositoryInterface;

interface ScoreRepositoryInterface extends BaseRepositoryInterface
{
    public function submitScoreJudge(array $data);
    public function getScoreByCategory();
}
