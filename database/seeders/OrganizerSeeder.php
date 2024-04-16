<?php

namespace Database\Seeders;

use App\Models\Organizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $organizers = [
            [
                'name' => 'Organizer A',
                'position' => 'Manager',
                'image' => 'path/to/image1.jpg',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
            ],
            [
                'name' => 'Organizer B',
                'position' => 'Assistant',
                'image' => 'path/to/image2.jpg',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            ],
            [
                'name' => 'Organizer C',
                'position' => 'Director',
                'image' => 'path/to/image3.jpg',
                'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.',
            ],
            [
                'name' => 'Organizer D',
                'position' => 'Coordinator',
                'image' => 'path/to/image4.jpg',
                'description' => 'Sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
            ],
            [
                'name' => 'Organizer E',
                'position' => 'Developer',
                'image' => 'path/to/image5.jpg',
                'description' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.',
            ],
        ];

        Organizer::truncate();
        foreach ($organizers as $organizer)
        {
            Organizer::create($organizer);
        }
    }
}
