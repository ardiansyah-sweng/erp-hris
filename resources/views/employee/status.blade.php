<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Status Filter</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .status-active {
      background: #d1fae5;
      color: #065f46;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-inactive {
      background: #fee2e2;
      color: #991b1b;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }
    </style>
  </head>

  <body>

    <div class="container mt-5">

      <div class="alert alert-warning">
        Halaman Pengujian Filter Status Employee
      </div>

      <h3 class="mb-4">Filter Status Karyawan</h3>

      <div class="mb-4">

        <a href="{{ url('/employees/status-temp') }}"
          class="btn {{ !$statusFilter ? 'btn-primary' : 'btn-outline-primary' }}">
          Semua
        </a>

        <a href="{{ url('/employees/status-temp?status=active') }}"
          class="btn {{ $statusFilter == 'active' ? 'btn-success' : 'btn-outline-success' }}">
          Active
        </a>

        <a href="{{ url('/employees/status-temp?status=inactive') }}"
          class="btn {{ $statusFilter == 'inactive' ? 'btn-danger' : 'btn-outline-danger' }}">
          Inactive
        </a>

      </div>

      <table class="table table-bordered table-hover">

        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>

          @forelse($employees as $employee)

          <tr>
            <td>{{ $employee->id }}</td>

            <td>{{ $employee->name }}</td>

            <td>{{ $employee->email }}</td>

            <td>
              {{ $employee->jobrole->name ?? '-' }}
            </td>

            <td>
              @if(strtolower($employee->status) == 'active')
              <span class="status-active">
                Active
              </span>
              @else
              <span class="status-inactive">
                Inactive
              </span>
              @endif
            </td>

          </tr>

          @empty

          <tr>
            <td colspan="5" class="text-center">
              Tidak ada data employee
            </td>
          </tr>

          @endforelse

        </tbody>

      </table>

    </div>

  </body>

</html>