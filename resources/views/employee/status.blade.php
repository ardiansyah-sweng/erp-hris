<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Status Karyawan - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 12px;
        }
        .card-header {
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }
        .badge-active {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .badge-inactive {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="alert alert-warning d-flex align-items-center shadow-sm" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <div>
            <strong>Catatan Pengembangan:</strong> Halaman UI ini dibuat khusus untuk testing fitur filter status agar tidak menabrak file <code>index.blade.php</code> milik tim lain.
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 m-1"><i class="fa-solid fa-users me-2"></i> Manajemen Status Karyawan</h5>
            
            <div class="btn-group" role="group" aria-label="Filter Status">
                <a href="{{ route('employees.status.temp') }}" 
                   class="btn btn-sm btn-outline-light {{ request('status') == '' ? 'active' : '' }}">
                    <i class="fa-solid fa-list me-1"></i> Semua
                </a>
                <a href="{{ route('employees.status.temp', ['status' => 'active']) }}" 
                   class="btn btn-sm btn-outline-success {{ request('status') == 'active' ? 'active text-white' : '' }}">
                    <i class="fa-solid fa-circle-check me-1"></i> Active
                </a>
                <a href="{{ route('employees.status.temp', ['status' => 'inactive']) }}" 
                   class="btn btn-sm btn-outline-danger {{ request('status') == 'inactive' ? 'active text-white' : '' }}">
                    <i class="fa-solid fa-circle-xmark me-1"></i> Inactive
                </a>
            </div>
        </div>
        
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 8%">No</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Email Resmi</th>
                            <th scope="col">No. Handphone</th>
                            <th scope="col" class="text-center" style="width: 15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $key => $employee)
                        <tr>
                            <td><strong>{{ $key + 1 }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 14px;">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $employee->name }}</span>
                                </div>
                            </td>
                            <td><span class="text-muted">{{ $employee->email }}</span></td>
                            <td>{{ $employee->phone_number }}</td>
                            <td class="text-center">
                                @if(strtolower($employee->status) == 'active')
                                    <span class="badge badge-active px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle text-success me-1" style="font-size: 8px;"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-inactive px-3 py-2 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle text-danger me-1" style="font-size: 8px;"></i> Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open d-block mb-2" style="font-size: 2rem;"></i>
                                Data employee dengan status ini tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>