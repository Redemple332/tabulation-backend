<?php

namespace App\Imports\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithMapping;
HeadingRowFormatter::default('none');

class UserImport implements ToCollection, WithHeadingRow,
SkipsOnError,
WithValidation,
SkipsOnFailure,
WithBatchInserts,
WithChunkReading,
WithMultipleSheets,
WithMapping
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param Collection $collection
    */
    private $data = [];
    protected $rowCount = 0;
    protected $isValidFile = false;


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $permit =  User::where('email', $row['Email'])->first();
            if(!$permit){
                $this->rowCount++;
                $permit = User::create([
                    'Email' => $row['Email'],
                ]);
            }

        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function rules(): array
    {
        return [
            '*.Email' => ['required','string'],
        ];
    }

    public function customValidationMessages()
    {

        return [
            '*.Email.unique' => 'The User has already been imported.',
        ];
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function isValidTemplate()
    {
        return $this->isValidFile;
    }

    public function isEmptyWhen(array $row)
    {
        try {
            $this->isValidFile = true;
            return $row['Email'] == "";
        } catch (\Throwable $th) {
            $this->isValidFile = false;
            return true;
        }
    }
    public function findByName($model, $name)
    {

    }
    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    public function uniqueBy()
    {
        return 'Email';
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function map($row): array
    {

        return [
            'Email' => $row['Email'],
        ];

    }
    private function isValidDate($date)
    {
        try {
            if($date == null) return false;
            Carbon::parse($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
