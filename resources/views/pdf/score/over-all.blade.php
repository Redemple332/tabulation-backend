<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabulation Sheet</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>
    <div class="tabulation-sheet">
        <h4>{{ $event->name }}</h4>
        <p>{{ $event->name }}<br> {{ $event->description }}<br></p>
        <h4>TABULATION SHEET</h4>
        <div class="table-responsive">
            <h6>Final</h6>
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Contestant No.</th>
                        <th>Name</th>
                        <th>Average Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $score)
                        <tr>
                            <td>{{ $score['candidate']['no'] }}</td>
                            <td>{{ $score['candidate']['full_name'] }}</td>
                            <td>{{ $score['average_score'] }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center mt-5">
        <p class="signature">Tabulator</p>
    </div>
</body>

</html>
