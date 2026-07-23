<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $payroll->employee->name ?? 'Karyawan' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .company-title {
            font-size: 22px;
            font-weight: bold;
            color: #4f46e5;
            letter-spacing: 0.5px;
        }
        .company-sub {
            font-size: 11px;
            color: #6b7280;
        }
        .document-title {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
        }
        .document-sub {
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .info-label {
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            width: 20%;
        }
        .info-val {
            font-weight: 600;
            color: #111827;
            width: 30%;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .salary-table th {
            background-color: #f3f4f6;
            color: #374151;
            text-align: left;
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }
        .salary-table td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            background-color: #eef2ff;
            font-weight: bold;
            font-size: 14px;
            color: #4f46e5;
            border-top: 2px solid #4f46e5;
            border-bottom: 2px solid #4f46e5;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .footer-signature {
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
            float: right;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #9ca3af;
            width: 180px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

    @php
        $namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulanNama = $namaBulan[$payroll->month] ?? $payroll->month;
    @endphp

    <!-- Kop Header Perusahaan -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="company-title">ERP HRIS SYSTEM</div>
                    <div class="company-sub">Sistem Informasi Manajemen Sumber Daya Manusia</div>
                </td>
                <td>
                    <div class="document-title">SLIP GAJI</div>
                    <div class="document-sub">Periode: {{ $bulanNama }} {{ $payroll->year }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Data Karyawan -->
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Karyawan</td>
            <td class="info-val">: {{ $payroll->employee->name ?? '-' }}</td>
            <td class="info-label">ID Karyawan</td>
            <td class="info-val">: {{ $payroll->employee->employee_code ?? ('EMP-' . str_pad($payroll->employee->id ?? 0, 4, '0', STR_PAD_LEFT)) }}</td>
        </tr>
        <tr>
            <td class="info-label">Jabatan / Role</td>
            <td class="info-val">: {{ $payroll->employee->jobrole->role ?? '-' }}</td>
            <td class="info-label">Status Bayar</td>
            <td class="info-val">: 
                @if(strtolower($payroll->status) == 'paid')
                    <span class="badge badge-paid">PAID</span>
                @else
                    <span class="badge badge-pending">PENDING</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="info-label">Email</td>
            <td class="info-val">: {{ $payroll->employee->email ?? '-' }}</td>
            <td class="info-label">Tanggal Cetak</td>
            <td class="info-val">: {{ now()->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <!-- Rincian Komponen Gaji -->
    <table class="salary-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Komponen Penggajian</th>
                <th>Kategori</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 5%;">1</td>
                <td>Gaji Pokok</td>
                <td>Penerimaan</td>
                <td class="text-right">{{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Tunjangan (Allowances)</td>
                <td>Penerimaan</td>
                <td class="text-right">+ {{ number_format($payroll->allowances, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Potongan (Deductions)</td>
                <td>Potongan</td>
                <td class="text-right" style="color: #dc2626;">- {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">TOTAL GAJI BERSIH (TAKE HOME PAY):</td>
                <td class="text-right">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="footer-signature">
        <div class="signature-box">
            <p style="margin-bottom: 5px;">Yogyakarta, {{ now()->translatedFormat('d F Y') }}</p>
            <p style="font-weight: bold; color: #4b5563;">Manajer Keuangan / HRD</p>
            <div class="signature-line"></div>
            <p style="font-size: 11px; color: #6b7280; margin-top: 5px;">( Tim HRIS ERP )</p>
        </div>
    </div>

</body>
</html>
