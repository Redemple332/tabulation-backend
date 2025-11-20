<?php

namespace App\Exports\Score;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScoreReportExport implements FromView, WithStyles
{
    public $event;
    public $results;

    public function __construct($event, $results)
    {
        $this->event = $event;
        $this->results = $results;
    }

    public function view(): View
    {
        return view('excel.over-all', [
            'event' => $this->event,
            'results' => $this->results,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold headers
            1 => ['font' => ['bold' => true]],
        ];
    }
}
