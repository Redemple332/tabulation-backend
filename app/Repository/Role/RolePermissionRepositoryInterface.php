<?php
namespace App\Repository\Role;

use App\Repository\Base\BaseRepositoryInterface;

interface RolePermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function setRolePermissions(array $attributes);
    public function updateRolePermission(array $attributes);
}