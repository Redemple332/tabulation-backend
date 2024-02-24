<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'id' => "9955ffde-c38c-449a-9a27-3ebac65d405d",
            'name' => "Sample Name",
            'date' => now()->format('Y-m-d'),
            'icon' => '',
            'banner' => '',
            'category_id' => null,
            'description' => 'description'
        ]);
    }
}
