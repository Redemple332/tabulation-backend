<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Score;
use App\Models\Candidate;
use Illuminate\Support\Facades\File;

class TalentScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = 'talent_scores.csv'; // your CSV file name
        $path = database_path("seeders/csv/{$csvFile}");
        $judgeId = "9955ffde-c38c-449a-9a27-3ebac65d405c";
        $categoryId = "a078b7b7-9c51-4ee1-b978-10a4a74cf2f9";

        Score::where('judge_id', $judgeId)
            ->where('category_id', $categoryId)
            ->delete();

        if (!File::exists($path)) {
            $this->command->error("CSV file not found: {$path}");
            return;
        }

        $csvFileHandle = fopen($path, 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFileHandle, 2000, ",")) !== false) {
            if (!$firstline) {

                // Assuming your CSV columns are: candidate_name, score
                $candidateName = $data[0] ?? null;
                $scoreValue    = $data[1] ?? null;

                if ($candidateName && $scoreValue !== null) {
                    // Find candidate by name
                    $candidate = Candidate::where('first_name', $candidateName)->first();

                    if ($candidate) {
                        Score::create([
                            'judge_id'     => $judgeId,
                            'category_id'  => $categoryId,
                            'candidate_id' => $candidate->id,
                            'score'        => $scoreValue,
                            'description'  => "Auto score for {$candidateName}",
                        ]);
                    } else {
                        $this->command->warn("Candidate not found: {$candidateName}");
                    }
                }
            }
            $firstline = false;
        }

        fclose($csvFileHandle);

        $this->command->info("Seeded: Scores from {$csvFile}");
    }
}
