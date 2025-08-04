<!DOCTYPE html>
<html>

<head>
    <title>Laporan Zakat</title>
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
    <h3>Laporan Zakat</h3>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Muzakki</th>
                <th>Jenis Zakat</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->zakat_transaction_date}}</td>
                <td>{{ $item->muzakki->name }}</td>
                <td>{{ $item->types_of_zakat }}</td>
                <td>{{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>