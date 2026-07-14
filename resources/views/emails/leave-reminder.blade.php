<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; color: #333;">
    <h2>Reminder: Pengajuan Cuti Belum Diproses</h2>
    <p>Berikut daftar pengajuan cuti yang masih berstatus <strong>Pending</strong>:</p>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f3f4f6;">
                <th>ID Karyawan</th>
                <th>Nama</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Alasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaveRequests as $leave)
                <tr>
                    <td>{{ $leave->employee_id }}</td>
                    <td>{{ $leave->employee_name }}</td>
                    <td>{{ $leave->start_date }}</td>
                    <td>{{ $leave->end_date }}</td>
                    <td>{{ $leave->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px; font-size: 12px; color: #888;">
        Email ini dikirim otomatis oleh sistem ERP HRIS.
    </p>
</body>
</html>
