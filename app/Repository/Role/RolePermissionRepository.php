<?php

namespace App\Repository\Role;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Repository\Base\BaseRepository;
use Illuminate\Validation\ValidationException;

class RolePermissionRepository extends BaseRepository implements RolePermissionRepositoryInterface
{
    public function __construct(RolePermission $model)
    {
        parent::__construct($model);
    }

    public function setRolePermissions(array $attributes) 
    {
        foreach($attributes['permission_ids'] as $p_id) 
        {
            $permission = Permission::find($p_id);

            if(!$permission) {
                throw ValidationException::withMessages([
                    'permission_not_found' => "Permission not found"
                ]);
            }

            $current_permissions = $this->model->where('role_id', $attributes['role_id'])->get();
            foreach($current_permissions as $curr_permission) {
                $curr_permission->delete();
            }
            
            $this->model->updateOrCreate([
                'role_id' => $attributes['role_id'],
                'permission_id' => $permission->id
            ]);
        }
    }

    public function updateRolePermission(array $attributes)
    {
        $role = Role::find($attributes['role_id']);

        if ($role) {
            if (isset($attributes['permission'])) {

            $permission = $this->model->where('role_id', $attributes['role_id'])->where('permission_id', $attributes['permission']['id'])->first();

                if ($permission) {
                    $role->permissions()->detach($permission->permission_id);
                    return "inactive";
                }
            } else {
                $permission = $this->model->create([
                    'permission_id' => $attributes['id'],
                    'role_id' => $attributes['role_id']
                ]);
                return "active";
            }
        }
    }
}