<?php

namespace App\Repository\Event;

use App\Models\Event;
use App\Repository\Base\BaseRepository;
use App\Repository\Event\EventRepositoryInterface;


class EventRepository extends BaseRepository implements EventRepositoryInterface
{

    /**
     * Event Repository constructor.
     *
     * @param Event $model
     */
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

}
