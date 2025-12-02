<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Score;
use App\Models\Candidate;
class TalentScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $judgeId = "9955ffde-c38c-449a-9a27-3ebac65d405c";
        $categoryId = "a078b7b7-9c51-4ee1-b978-10a4a74cf2f9";

        // Get all candidates
        $candidates = Candidate::all();

        foreach ($candidates as $candidate) {

            // generate a unique score per candidate
            $scoreValue = rand(80, 100); // change range if needed

            Score::create([
                'judge_id'     => $judgeId,
                'category_id'  => $categoryId,
                'candidate_id' => $candidate->id,
                'score'        => $scoreValue,
                'description'  => "Auto score for {$candidate->id}",
            ]);
        }
    }
}
