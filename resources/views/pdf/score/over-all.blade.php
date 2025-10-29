<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabulation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
        }

        .tabulation-sheet {
            margin: 40px;
        }

        h4,
        h5,
        h6,
        p {
            text-align: center;
            margin: 0;
        }

        h4 {
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .signature {
            display: inline-block;
            position: relative;
            margin-top: 60px;
        }

        .signature::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            border-top: 1px solid black;
        }

        .signature p {
            margin: 0;
        }

        .category-table {
            margin-top: 15px;
        }

        .category-table th {
            background-color: #f8f9fa;
        }

        .final-score {
            font-weight: bold;
            background-color: #e9ecef;
        }

        /* Force summary table to start on a new page */
        .page-break {
            page-break-before: always;
        }

        @media print {
            .tabulation-sheet {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="tabulation-sheet">
        <h4>{{ $event->name }}</h4>
        <p>{{ $event->description }}</p>
        <h4 class="mt-3">TABULATION</h4>
        <h6 class="text-muted mb-3">Final Results</h6>

        {{-- Main Detailed Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Contestant No.</th>
                        <th>Contestant Name</th>
                        <th>Category %</th>
                        <th>Average Score</th>
                        <th>Weighted Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $candidate)
                        @foreach ($candidate['categories'] as $index => $category)
                            <tr>
                                @if ($index === 0)
                                    <td rowspan="{{ count($candidate['categories']) }}">
                                        {{ $candidate['candidate_no'] }}
                                    </td>
                                    <td rowspan="{{ count($candidate['categories']) }}">
                                        {{ $candidate['candidate_name'] }}
                                    </td>
                                @endif
                                <td><b>{{ $category['category'] }}:</b> {{ $category['percentage'] }}%</td>
                                <td>{{ number_format($category['avg_per_category'], 2) }}</td>
                                <td>{{ number_format($category['weighted_score'], 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="final-score">
                            <td colspan="4" class="text-right">Final Score:</td>
                            <td colspan="2">{{ number_format($candidate['final_score'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No results available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-center mt-5">
            <p class="signature">Tabulator</p>
        </div>
    </div>

    {{-- ✅ Summary Table on New Page --}}
    <div class="tabulation-sheet page-break">
        <h4>{{ $event->name }}</h4>
        <p>{{ $event->description }}</p>
        <h4 class="mt-3">TABULATION</h4>
        <h6 class="text-muted mb-3">Final Result</h6>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th style="text-align: left !important">Candidate</th>
                        <th>Final Score</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $candidate)
                        <tr>
                            <td style="text-align: left !important">#{{ $candidate['candidate_no'] }} - {{ $candidate['candidate_name'] }}</td>
                            <td>{{ number_format($candidate['final_score'], 2) }}</td>
                            <td>{{ $candidate['rank'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-5">
            <p class="signature">Tabulator</p>
        </div>
    </div>
</body>

</html>
