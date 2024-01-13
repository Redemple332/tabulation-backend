<?php

namespace App\Repository\Permission;

use App\Models\Permission;
use App\Repository\Base\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getPermissionOptions()
    {
        $permissions =  $this->model->with('permissionGroup:id,name,description')
            ->where('route', 'not like', '%' . '.restore')
            ->where('route', 'not like', '%' . '.option')
            ->where('route', 'not like', '%' . '.show')
            ->where('route', 'not like', 'generated::' . '%')
            ->where('route', '<>', 'login')
            ->where('route', '<>', 'sanctum.csrf-cookie')
            ->where('route', 'not like', 'user.' . '%' )
            ->where('route', 'not like', 'permissions' .'%' )
            ->where('route', 'not like', 'permission-groups' .'%' )
            ->where('route', 'not like', 'gh_types' .'%' )
            ->orWhere('route', '=', 'permissions.option')->get();
        return $permissions->groupBy('name');
    }
}