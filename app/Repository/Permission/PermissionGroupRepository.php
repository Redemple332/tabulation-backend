<?php

namespace App\Repository\Permission;

use App\Models\PermissionGroup;
use App\Repository\Base\BaseRepository;

class PermissionGroupRepository extends BaseRepository implements PermissionGroupRepositoryInterface
{
    public function __construct(PermissionGroup $model)
    {
        parent::__construct($model);
    }
}