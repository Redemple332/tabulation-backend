<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .final-score {
            font-weight: bold;
            background: #e9ecef;
        }

        .signature {
            margin-top: 40px;
            text-align: center;
            font-weight: bold;
        }

        .page-break {
            mso-break-before: page;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>

    {{-- ======================= --}}
    {{-- MAIN DETAILED TABULATION --}}
    {{-- ======================= --}}

    <div>
        <p class="title">{{ $event->name }}</p>
        <p class="subtitle">{{ $event->description }}</p>
        <p class="title">TABULATION</p>
        <p class="subtitle">Final Results</p>

        <table>
            <thead>
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

                            <td>{{ $category['category'] }} ({{ $category['percentage'] }}%)</td>
                            <td>{{ number_format($category['avg_per_category'], 2) }}</td>
                            <td>{{ number_format($category['weighted_score'], 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="final-score">
                        <td colspan="4" style="text-align: right;">Final Score:</td>
                        <td>{{ number_format($candidate['final_score'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No results available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- ======================= --}}
    {{-- SUMMARY TABLE - NEW PAGE --}}
    {{-- ======================= --}}
    <div class="page-break">
        <table>
            <thead>
                <tr>
                    <th style="text-align: left;">Candidate</th>
                    <th>Final Score</th>
                    <th>Rank</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($results as $candidate)
                    <tr>
                        <td style="text-align: left;">#{{ $candidate['candidate_no'] }} - {{ $candidate['candidate_name'] }}</td>
                        <td>{{ number_format($candidate['final_score'], 2) }}</td>
                        <td>{{ $candidate['rank'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
