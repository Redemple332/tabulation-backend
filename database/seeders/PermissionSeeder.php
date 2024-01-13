<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as FacadesRoute;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = FacadesRoute::getRoutes()->getRoutesByName();


        foreach ($routes as $key => $route) {
            $parts = explode('.', $key);
            $group_name = ucfirst($parts['0']) . " Management";

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

            $if_exist = PermissionGroup::where('name', str_replace('.', ' ', $group_name))->first();

            if (!$if_exist) {
                $group = PermissionGroup::create(
                    [
                        'name' => str_replace('.', ' ', $group_name),
                        'description' => str_replace('.', ' ', $group_name)
                    ]
                );
                $permissions = $group->permissions()->create([
                    'name' => $group->name,
                    'description' => $group->description,
                    'route' => $key,
                ]);

                echo $permissions->id . "Permission\n";
            } else {

                $if_exist->toArray();
                $if_exist->jsonSerialize();
                $if_exist->toJson();
            }
        }
    }
}
