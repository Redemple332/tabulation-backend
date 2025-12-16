<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabulation Sheet</title>
    <link rel="stylesheet" href="{{ public_path('css/bootstrap.css') }}">

    <style>
        .tabulation-sheet {
            margin: 20px;
        }

        .signature {
            position: relative;
            display: inline-block;
            margin: 0;
            padding: 0;
        }

        .signature::before {
            content: '';
            position: absolute;
            top: -10px;
            /* Adjust the distance above the text */
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            border-top: 1px solid black;
            /* Adjust color and thickness as needed */
        }

        .tabulation-sheet h4,
        .tabulation-sheet p {
            text-align: center;
        }

        .tabulation-sheet table {
            width: 100%;
            margin-top: 20px;
        }

        .tabulation-sheet .table th,
        .tabulation-sheet .table td {
            text-align: center;
            vertical-align: middle;
        }

        .not-voted {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="tabulation-sheet">
        <h4>{{ $event->name }}</h4>
        <p>{{ $event->name }}<br> {{ $event->description }}</p>
        <h4>TABULATION SHEET</h4>
        <div class="table-responsive">
            @forelse ($results as $result)
                <h6>{{ $result['name'] }} - {{ $result['percentage'] }}%</h6>
                <table class="table table-bordered taScble-striped table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: left !important">Contestant</th>
                            {{-- @forelse ($result['headers'] as  $header)
                                <th>Judge {{ $header->judge_no }}</th>
                            @empty
                            @endforelse --}}
                            <th>Total AVG</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($result['judges_score'] as $score)
                            <tr>
                                <td style="text-align: left !important">#{{ $score['candidate_no'] }} -
                                    {{ $score['candidate_name'] }}</td>
                                {{-- @forelse ($score['judge_score'] as $judge)
                                    <td class="{{ $judge['judge_score'] === 'Not Already Voted' ? 'not-voted' : '' }}" > {{ $judge['judge_score'] }}</td>
                                @empty
                                @endforelse --}}
                                <td>{{ $score['average'] }}</td>
                                <td>{{ $score['rank'] }}</td>
                            </tr>
                        @empty
                        @endforelse

                    </tbody>
                </table>
            @empty
            @endforelse

        </div>
    </div>
    <div class="text-center mt-5">
        <p class="signature">Tabulator</p>
    </div>
</body>

</html>
