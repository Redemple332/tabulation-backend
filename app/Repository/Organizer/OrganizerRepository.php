<?php

namespace App\Repository\Organizer;

use App\Models\Organizer;
use App\Repository\Base\BaseRepository;
use App\Repository\Organizer\OrganizerRepositoryInterface;


class OrganizerRepository extends BaseRepository implements OrganizerRepositoryInterface
{

    /**
     * Organizer Repository constructor.
     *
     * @param Organizer $model
     */
    public function __construct(Organizer $model)
    {
        parent::__construct($model);
    }

}
