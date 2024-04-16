<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();
        $categories = [
            ['name' => 'Sports Wear', 'percentage' => '100', 'min_score' => 75, 'max_score' => 100, 'status' => 0],
            ['name' => 'Talent', 'percentage' => '100', 'min_score' => 75 , 'max_score' => 100, 'status' => 0],
            ['name' => 'Swimsuit', 'percentage' => '100', 'min_score' => 75 , 'max_score' => 100, 'status' => 0],
            ['name' => 'Q & A', 'percentage' => '100', 'min_score' => 75 , 'max_score' => 100, 'status' => 0],
        ];

        foreach ($categories as $category)
        {
            Category::create($category);
        }
    }
}
