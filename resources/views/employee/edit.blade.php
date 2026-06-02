<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan - ERP HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Edit Data Karyawan</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ $employee->name }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ $employee->email }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="job_role_id" class="form-label">Jabatan (Job Role)</label>
                                <select class="form-select" id="job_role_id" name="job_role_id">
                                    <option value="1" {{ $employee->job_role_id == 1 ? 'selected' : '' }}>Software Enginer</option>
                                    <option value="2" {{ $employee->job_role_id == 2 ? 'selected' : '' }}>HR Department</option>
                                    <option value="3" {{ $employee->job_role_id == 3 ? 'selected' : '' }}>Backend Developer</option>
                                </select>
                                <div class="form-text text-muted">Data jabatan diambil dari tabel <i>job_roles</i>.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $employee->address }}</textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-3 text-center text-muted">
                <small>Tugas View Edit: Muhammad falih tlyasa | Proyek ERP RPL-PKPL </small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 