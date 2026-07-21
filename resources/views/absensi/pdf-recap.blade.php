<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi {{ $startDate }} s.d {{ $endDate }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            color: #4f46e5;
            margin: 0 0 5px 0;
        }
        .header p {
            font-size: 11px;
            color: #666;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background-color: #4f46e5;
            color: white;
            padding: 8px 6px;
            text-align: center;
            font-size: 9px;
            text-transform: uppercase;
        }
        tbody td {
            padding: 6px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
        }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Absensi Karyawan</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-left">Karyawan</th>
                <th>Hadir</th>
                <th>Tidak Hadir</th>
                <th>Terlambat</th>
                <th>Sakit</th>
                <th>Cuti</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recap as $r)
                <tr>
                    <td class="text-left" style="font-weight: 600;">{{ $r['employee_name'] }}</td>
                    <td>{{ $r['summary']['present'] }}</td>
                    <td>{{ $r['summary']['absent'] }}</td>
                    <td>{{ $r['summary']['late'] }}</td>
                    <td>{{ $r['summary']['sick'] }}</td>
                    <td>{{ $r['summary']['leave'] }}</td>
                    <td style="font-weight: 600;">{{ $r['total_records'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        Tidak ada data pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }} | ERP-HRIS
    </div>
</body>
</html>
