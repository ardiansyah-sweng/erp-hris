<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Presensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 4px;
        }

        p {
            margin-top: 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f3f3f3;
        }
    </style>
</head>

<body>
    <h2>Rekap Presensi per Periode</h2>
    <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
        {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Hadir</th>
                <th>Tidak Hadir</th>
                <th>Terlambat</th>
                <th>Sakit</th>
                <th>Cuti</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recap as $item)
                <tr>
                    <td>{{ $item['employee_name'] }}</td>
                    <td>{{ $item['summary']['present'] }}</td>
                    <td>{{ $item['summary']['absent'] }}</td>
                    <td>{{ $item['summary']['late'] }}</td>
                    <td>{{ $item['summary']['sick'] }}</td>
                    <td>{{ $item['summary']['leave'] }}</td>
                    <td><b>{{ $item['total_records'] }}</b></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
