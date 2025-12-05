<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class JudgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       for ($i = 1; $i <= 9; $i++) {
        User::updateOrCreate(
            ['judge_no' => $i], // match existing judge
            [
                'id'         => Str::uuid()->toString(),
                'first_name' => 'Judge',
                'last_name'  => (string) $i,
                'email'      => "judge{$i}@gmail.com",
                'password'   => "judge@{$i}",
                'role_id'    => 'b9612992-1e02-4572-b618-6bcd60d651ac',
            ]
        );
    }

    }
}
