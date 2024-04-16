<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();

        $r = new Role();
        $r->id = "8787fc94-01e7-4f3b-a988-3b29409d0b76";
        $r->name = 'SuperAdmin';
        $r->description = 'SuperAdmin';
        $r->save();

        $r = new Role();
        $r->id = "34300bad-3e5d-4511-b04f-721c2dc8e0e7";
        $r->name = 'Admin';
        $r->description = 'Admin';
        $r->save();

        $r = new Role();
        $r->id = "b9612992-1e02-4572-b618-6bcd60d651ac";
        $r->name = 'Judge';
        $r->description = 'Judge';
        $r->save();
    }
}
