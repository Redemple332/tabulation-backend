<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RPGSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            EventSeeder::class,
            // CategorySeeder::class,
            // ScoreSeeder::class,
            // CandidateSeeder::class
        ]);
    }
}
