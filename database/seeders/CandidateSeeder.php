<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Score;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Score::truncate();
        Candidate::truncate();
        $candidates = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'no' => '1',
                'gender' => 'Female',
                'age' => 25,
                'image' => 'path/to/image1.jpg',
                'contact' => 'john.doe@example.com',
                'address' => '123 Main Street, City, Country',
                'status' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'no' => '2',
                'gender' => 'Female',
                'age' => 30,
                'image' => 'path/to/image2.jpg',
                'contact' => 'jane.smith@example.com',
                'address' => '456 Elm Street, City, Country',
                'status' => 1,
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'no' => '3',
                'gender' => 'Female',
                'age' => 28,
                'image' => 'path/to/image3.jpg',
                'contact' => 'michael.johnson@example.com',
                'address' => '789 Oak Street, City, Country',
                'status' => 1,
                'description' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'no' => '4',
                'gender' => 'Female',
                'age' => 26,
                'image' => 'path/to/image4.jpg',
                'contact' => 'emily.davis@example.com',
                'address' => '101 Pine Street, City, Country',
                'status' => 1,
                'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'no' => '5',
                'gender' => 'Female',
                'age' => 32,
                'image' => 'path/to/image5.jpg',
                'contact' => 'david.brown@example.com',
                'address' => '222 Maple Street, City, Country',
                'status' => 1,
                'description' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            ],
        ];

        foreach ($candidates as $candidate)
        {
            Candidate::create($candidate);
        }
    }
}
