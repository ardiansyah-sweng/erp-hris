<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Status Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }
        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
        }
        .sub-title {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }
        /* Top Stats Card style */
        .stats-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #f3f4f6;
            padding: 24px;
            width: 240px;
        }
        .stats-icon-bg {
            width: 40px;
            height: 40px;
            background-color: #eeecfd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6366f1;
        }
        /* Filter Button style mirip tombol "Tambah" tapi versi outline/aktif */
        .btn-filter-group .btn {
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            color: #4b5563;
            transition: all 0.2s;
        }
        .btn-filter-group .btn:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }
        .btn-filter-group .btn.active-all {
            background-color: #6366f1;
            color: #ffffff;
            border-color: #6366f1;
        }
        .btn-filter-group .btn.active-success {
            background-color: #10b981;
            color: #ffffff;
            border-color: #10b981;
        }
        .btn-filter-group .btn.active-danger {
            background-color: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
        }
        /* Main Content Card */
        .content-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .card-header-custom {
            padding: 24px;
            border-bottom: 1px solid #f3f4f6;
        }
        /* Table Style */
        .table-custom th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            background-color: #ffffff;
            border-bottom: 1px solid #f3f4f6;
            padding: 16px 24px;
        }
        .table-custom td {
            font-size: 14px;
            color: #111827;
            padding: 20px 24px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .table-custom tr:last-child td {
            border-bottom: none;
        }
        .employee-name {
            font-weight: 600;
            color: #111827;
        }
        .employee-email {
            color: #6b7280;
        }
        /* Status Badge Style sesuai gambar */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 500;
        }
        .badge-status.status-aktif {
            background-color: #e6f7f0;
            color: #10b981;
        }
        .badge-status.status-aktif::before {
            content: '';
            width: 6px;
            height: 6px;
            background-color: #10b981;
            border-radius: 50%;
        }
        .badge-status.status-nonaktif {
            background-color: #fee2e2;
            color: #ef4444;
        }
        .badge-status.status-nonaktif::before {
            content: '';
            width: 6px;
            height: 6px;
            background-color: #ef4444;
            border-radius: 50%;
        }
        /* Temporary badge dev info */
        .dev-tag {
            font-size: 11px;
            background-color: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
            padding: 4px 10px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container my-5" style="max-width: 1140px;">
    
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="main-title">Manajemen Status Karyawan</h1>
            <p class="sub-title">Kelola daftar keaktifan bekerja dan filter data operasional pegawai.</p>
        </div>
        <span class="dev-tag"><i class="fa-solid fa-code me-1"></i> Sandbox UI Sementara</span>
    </div>

    <div class="stats-card mb-4 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="stats-icon-bg">
                <i class="fa-solid fa-box-archive" style="font-size: 16px;"></i>
            </div>
            <div>
                <span style="font-size: 13px; color: #6b7280; font-weight: 500;">Total Karyawan</span>
                <div class="mt-1" style="font-size: 24px; font-weight: 700; color: #111827;">
                    {{ $employees->count() }} <span style="font-size: 14px; font-weight: 500; color: #10b981; margin-left: 4px;">pegawai</span>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <span style="font-size: 16px; font-weight: 600; color: #111827;">Daftar Karyawan</span>
            
            <div class="btn-filter-group d-flex gap-2">
                <a href="{{ route('employees.status.temp') }}" 
                   class="btn {{ request('status') == '' ? 'active-all' : '' }}">
                    Semua
                </a>
                <a href="{{ route('employees.status.temp', ['status' => 'active']) }}" 
                   class="btn {{ request('status') == 'active' ? 'active-success' : '' }}">
                    Active
                </a>
                <a href="{{ route('employees.status.temp', ['status' => 'inactive']) }}" 
                   class="btn {{ request('status') == 'inactive' ? 'active-danger' : '' }}">
                    Inactive
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 8%">No</th>
                        <th scope="col" style="width: 30%">Nama Karyawan</th>
                        <th scope="col" style="width: 25%">Email Resmi</th>
                        <th scope="col" style="width: 20%">No. Handphone</th>
                        <th scope="col" class="text-center" style="width: 17%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $key => $employee)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><span class="employee-name">{{ $employee->name }}</span></td>
                        <td><span class="employee-email">{{ $employee->email }}</span></td>
                        <td>{{ $employee->phone_number ?? '-' }}</td>
                        <td class="text-center">
                            @if(strtolower($employee->status) == 'active')
                                <span class="badge-status status-aktif">Active</span>
                            @else
                                <span class="badge-status status-nonaktif">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 24px; color: #9ca3af;"></i>
                            Data karyawan tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>