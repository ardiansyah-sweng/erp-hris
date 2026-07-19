<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $payroll->employee->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1f2937;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            color: #4f46e5;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header h2 {
            font-size: 14px;
            color: #374151;
            margin-top: 4px;
        }
        .header p {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }
        .info-table .label {
            font-weight: bold;
            color: #4b5563;
            width: 120px;
        }
        .info-table .value {
            color: #1f2937;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .salary-table th {
            background: #4f46e5;
            color: white;
            padding: 8px 12px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .salary-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .salary-table .text-right {
            text-align: right;
        }
        .salary-table .text-green {
            color: #059669;
        }
        .salary-table .text-red {
            color: #dc2626;
        }
        .salary-table .total-row td {
            font-weight: bold;
            font-size: 13px;
            border-top: 2px solid #4f46e5;
            border-bottom: none;
            background: #eef2ff;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
            width: 45%;
        }
        .signature .line {
            margin-top: 50px;
            border-top: 1px solid #1f2937;
            padding-top: 5px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Slip Gaji Karyawan</h1>
        <h2>ERP HRIS</h2>
        <p>Periode: {{ $bulan }} {{ $payroll->year }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Karyawan</td>
            <td class="value">: {{ $payroll->employee->name }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="value">: {{ $payroll->employee->jobrole->role ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="value">
                : <span class="status-badge {{ $payroll->status == 'paid' ? 'status-paid' : 'status-pending' }}">
                    {{ $payroll->status == 'paid' ? 'Lunas' : 'Pending' }}
                </span>
            </td>
        </tr>
    </table>

    <table class="salary-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Gaji Pokok</td>
                <td class="text-right">{{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-green">Tunjangan</td>
                <td class="text-right text-green">+ {{ number_format($payroll->allowances, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-red">Potongan</td>
                <td class="text-right text-red">- {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Gaji Bersih</td>
                <td class="text-right">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <div>
            <p>Diterima Oleh,</p>
            <div class="line">{{ $payroll->employee->name }}</div>
        </div>
        <div>
            <p>Mengetahui,</p>
            <div class="line">( HRD )</div>
        </div>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->format('d/m/Y H:i') }} — ERP HRIS
    </div>

</body>
</html>