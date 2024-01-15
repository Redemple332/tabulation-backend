<?php

namespace App\Repository\Candidate;

use App\Models\Candidate;
use App\Repository\Base\BaseRepository;
use App\Repository\Candidate\CandidateRepositoryInterface;


class CandidateRepository extends BaseRepository implements CandidateRepositoryInterface
{

    /**
     * Candidate Repository constructor.
     *
     * @param Candidate $model
     */
    public function __construct(Candidate $model)
    {
        parent::__construct($model);
    }

}
