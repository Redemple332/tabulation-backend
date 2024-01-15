<?php

namespace App\Repository\Sponsor;

use App\Models\Sponsor;
use App\Repository\Base\BaseRepository;
use App\Repository\Sponsor\SponsorRepositoryInterface;


class SponsorRepository extends BaseRepository implements SponsorRepositoryInterface
{

    /**
     * Sponsor Repository constructor.
     *
     * @param Sponsor $model
     */
    public function __construct(Sponsor $model)
    {
        parent::__construct($model);
    }

}
