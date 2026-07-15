<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job Role</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #dfe9f3);
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background: linear-gradient(135deg, #4e73df, #224abe);
        }

        .form-control {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        .btn-success {
            background: linear-gradient(135deg, #1cc88a, #17a673);
            border: none;
        }

        .btn-secondary {
            background: #858796;
            border: none;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg">
                <div class="card-header text-white text-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Job Role
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('jobrole.update', $jobrole->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Role -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-badge me-1"></i>
                                Job Role
                            </label>
                            <input type="text"
                                name="role"
                                value="{{ $jobrole->role }}"
                                class="w-full border rounded-lg px-3 py-2">
                        </div>

                        <!-- Departemen -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i>
                                Departemen
                            </label>
                            <select name="department" class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih Departemen</option>
                                <option value="IT" {{ $jobrole->department == 'IT' ? 'selected' : '' }}>IT</option>
                                <option value="Data" {{ $jobrole->department == 'Data' ? 'selected' : '' }}>Data</option>
                                <option value="Human Resources" {{ $jobrole->department == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                                <option value="Product" {{ $jobrole->department == 'Product' ? 'selected' : '' }}>Product</option>
                            </select>
                        </div>

                        <!-- Level -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-bar-chart me-1"></i>
                                Level
                            </label>
                            <select name="level" class="w-full border rounded-lg px-3 py-2">
                                <option value="">Pilih Level</option>
                                <option value="Staff" {{ $jobrole->level == 'Staff' ? 'selected' : '' }}>Staff</option>
                                <option value="Senior" {{ $jobrole->level == 'Senior' ? 'selected' : '' }}>Senior</option>
                                <option value="Manager" {{ $jobrole->level == 'Manager' ? 'selected' : '' }}>Manager</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-toggle-on me-1"></i>
                                Status
                            </label>
                            <select name="status" class="w-full border rounded-lg px-3 py-2">
                                <option value="Active" {{ $jobrole->status == 'Active' ? 'selected' : '' }}>Aktif</option>
                                <option value="On Leave" {{ $jobrole->status == 'On Leave' ? 'selected' : '' }}>Cuti</option>
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('jobrole.index') }}" class="btn btn-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>

                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Footer kecil -->
            <p class="text-center mt-3 text-muted small">
                © Sistem Manajemen Job Role
            </p>

        </div>
    </div>
</div>

</body>
</html>