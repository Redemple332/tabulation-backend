<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RPGSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::getRoutes()->getRoutesByName();

        Permission::Truncate();
        PermissionGroup::Truncate();

      $roles = ['SuperAdmin', 'Admin', 'User'];


        $actions = [
            'logs' => 'view logs',
            'restore' => 'restore',
            'export' => 'export',
            'index' => 'view list',
            'store' => 'create',
            'show' => 'show',
            'update' => 'edit',
            'destroy' => 'delete',
        ];

        foreach ($roles as $role) {
            foreach ($routes as $key => $route) {
                $parts = str_replace('_',' ', $key);
                $parts = explode('.', $parts);

                $group_name = ucfirst($parts['0']) . " Management";

                $route_action = end($parts);
                $route_action = $actions[$route_action] ?? $route_action;

                if (count($parts) > 2) {
                    $group_name = "";
                    foreach ($parts as $index => $part) {
                        if ((count($parts) - 1) > (int) $index) {
                            if ($group_name) {
                                $group_name = $group_name . " " . ucfirst($part);
                            } else {
                                $group_name = ucfirst($part);
                            }
                        }
                    }
                    $group_name = $group_name . " Management";
                }

                $group = PermissionGroup::updateOrCreate([
                    'name' => str_replace('.', ' ', $group_name),
                    'description' => str_replace('.', ' ', $group_name)
                ]);

                if ($group_name !== 'Ignition Management') {
                    $permission = Permission::updateOrCreate([
                        'name' => $group_name,
                        'description' => $route_action,
                        'route' => $key,
                        'permission_group_id' => $group->id
                    ]);
                }
            }
        }

        RolePermission::truncate();

        $roles = Role::all();

        foreach ($roles as $role) {
            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }
}
