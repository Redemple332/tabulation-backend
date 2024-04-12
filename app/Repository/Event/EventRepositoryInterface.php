<?php

namespace App\Repository\Event;

use App\Repository\Base\BaseRepositoryInterface;

interface EventRepositoryInterface extends BaseRepositoryInterface
{
    public function nextCategory();
}
