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
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-badge me-1"></i>
                                Nama Job Role
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control"
                                   value="{{ $jobrole->name ?? 'Admin' }}"
                                   placeholder="Masukkan nama job role"
                                   required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-card-text me-1"></i>
                                Deskripsi
                            </label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Masukkan deskripsi">{{ $jobrole->description ?? 'Deskripsi sementara' }}</textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-secondary px-4">
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