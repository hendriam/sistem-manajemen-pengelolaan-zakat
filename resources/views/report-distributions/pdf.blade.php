<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penyaluran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            padding: 6px;
            border: 1px solid #000;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3>Laporan Penyaluran</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Mustahik</th>
                <th>Program</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->distribution_date}}</td>
                <td>{{ $item->mustahik->name }}</td>
                <td>{{ $item->program }}</td>
                <td>{{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>