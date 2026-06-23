<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Status Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
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
        /* Filter Button style */
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
        /* Status Badge Style */
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

        /* PERBAIKAN RESPONSIVE LAYOUT */
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            padding: 20px 15px;
        }
        @media (min-width: 1024px) {
            .main-content {
                margin-left: 16rem; /* Geser sejauh lebar sidebar (w-64 = 256px) */
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 shadow-sm flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100 flex-shrink-0">
            <div class="bg-indigo-600 p-2 rounded-lg text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="font-bold text-xl text-gray-900 tracking-tight">ERP<span class="text-indigo-600">HRIS</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-0.5 overflow-y-auto">
            <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <div class="pt-5 pb-2">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-widest">Manajemen SDM</p>
            </div>

            <a href="/employees" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('employees*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Karyawan
            </a>

            <a href="/job-roles" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('job-roles*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Job Role
            </a>

            <div class="pt-5 pb-2">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-widest">Kehadiran & Waktu</p>
            </div>

            <a href="/absensi" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('absensi*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Absensi
            </a>

            <a href="{{ route('leave_request.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('leave-request*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Cuti & Izin
            </a>

            <div class="pt-5 pb-2">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-widest">Keuangan</p>
            </div>

            <a href="/penggajian" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->is('penggajian*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Penggajian
            </a>
        </nav>

        <div class="border-t border-gray-100 px-4 py-4 flex-shrink-0">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors group">
                <img class="h-8 w-8 rounded-full ring-2 ring-indigo-100 object-cover flex-shrink-0"
                     src="https://ui-avatars.com/api/?name=Admin+HR&background=4f46e5&color=fff&bold=true"
                     alt="User">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">Admin HR</p>
                    <p class="text-xs text-gray-500 truncate">admin@erphris.com</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <div class="container-fluid" style="max-width: 1140px;">
            
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
    </div>

</body>
</html>