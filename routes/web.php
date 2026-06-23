<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobroleController;
use App\Http\Controllers\PayrollController;


Route::post('/test-jobrole', [JobroleController::class, 'store']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// EMPLOYEE ROUTES
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

// ROUTE TEST EDIT EMPLOYEE
Route::get('/employee/test-edit', function () {
    $employee = (object) [
        'id' => 1,
        'name' => 'Budi Setiawan',
        'email' => 'budi@erp-hris.com',
        'job_role_id' => 1,
        'address' => 'Jl. Merdeka No. 45, Semarang'
    ];
    return view('employee.edit', compact('employee'));
});

Route::put('/employee/test-edit', function () {
    return "Tombol Update berhasil diklik!";
});

// JOB ROLE ROUTES
Route::get('/job-roles', function () {
    return view('job_role.index');
})->name('jobrole.index');

Route::get('/job-roles/create', function () {
    return view('job_role.create_jobrole');
})->name('jobrole.create');

Route::post('/job-roles', [JobroleController::class, 'store'])->name('jobrole.store');
Route::post('/test-jobrole', [JobroleController::class, 'store']);
Route::delete('/job-roles/{jobrole}', [JobroleController::class, 'destroy']);
Route::get('/job-roles/{id}', [JobroleController::class, 'show']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/profile', function () {
    return view('profile.index');
})->name('profile.index');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings.index');

// ROUTE EDIT JOB ROLE
Route::get('/job-roles/{id}/edit', function ($id) {
    $dummyJobRoles = [
        ['id' => 1, 'name' => 'Software Engineer', 'department' => 'IT', 'level' => 'Staff', 'status' => 'Active'],
        ['id' => 2, 'name' => 'Data Analyst', 'department' => 'Data', 'level' => 'Senior', 'status' => 'Active'],
        ['id' => 3, 'name' => 'HR Manager', 'department' => 'Human Resources', 'level' => 'Manager', 'status' => 'On Leave'],
        ['id' => 4, 'name' => 'Quality Assurance', 'department' => 'IT', 'level' => 'Staff', 'status' => 'Active'],
        ['id' => 5, 'name' => 'Product Manager', 'department' => 'Product', 'level' => 'Manager', 'status' => 'Active'],
    ];
    $jobrole = collect($dummyJobRoles)->firstWhere('id', $id);
    return view('job_role.edit', compact('jobrole'));
})->name('jobrole.edit');

// ABSENSI ROUTES
Route::get('/absensi', function () {
    return view('absensi.index');
})->name('absensi.index');

// ROUTE TEST EDIT EMPLOYEE
Route::get('/employee/test-edit', function () {

    $employee = (object) [
        'id' => 1,
        'name' => 'Budi Setiawan',
        'email' => 'budi@erp-hris.com',
        'job_role_id' => 1,
        'address' => 'Jl. Merdeka No. 45, Semarang'
    ];

    return view('employee.edit', compact('employee'));
});

Route::put('/employee/test-edit', function () {
    return "Tombol Update berhasil diklik! (Ini hanya simulasi, data belum tersimpan karena Controller Update asli belum disambungkan).";
});
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::get('/absensi', function () {
    return view('absensi.index');
})->name('absensi.index');

Route::get('/leave-request', function () {
    return view('leave_request.index');
});

Route::get('/leave-request', function () {
    $dummyLeaveRequests = [
        [
            'id' => '1',
            'employee_id' => 'EMP001',
            'employee_name' => 'Susanti Wijaya',
            'start_date' => '2026-06-10',
            'end_date' => '2026-06-12',
            'reason' => 'Liburan keluarga',
            'status' => 'Pending',
        ],
        [
            'id' => '2',
            'employee_id' => 'EMP002',
            'employee_name' => 'Budi Santoso',
            'start_date' => '2026-06-15',
            'end_date' => '2026-06-18',
            'reason' => 'Keperluan pribadi',
            'status' => 'Approved',
        ],
        [
            'id' => '3',
            'employee_id' => 'EMP003',
            'employee_name' => 'Andi Wijaya',
            'start_date' => '2026-06-20',
            'end_date' => '2026-06-22',
            'reason' => 'Kunjungan keluarga',
            'status' => 'Rejected',
        ],
    ];
    return view(
        'leave_request.index',
        compact('dummyLeaveRequests')
    );
})->name('leave_request.index');

Route::get('/leave-request/create', function () {
    return view('leave_request.create');
});

Route::get('/leave-request/{id}', function ($id) {

    $leaveRequest = [
        'id' => $id,
        'employee_id' => 'EMP001',
        'employee_name' => 'Susanti Wijaya',
        'start_date' => '2026-06-10',
        'end_date' => '2026-06-12',
        'reason' => 'Liburan keluarga',
        'status' => 'Pending',
        'created_at' => '2026-06-08',
    ];

    return view(
        'leave_request.detail',
        compact('leaveRequest')
    );
})->name('leave_request.detail');

Route::post('/payroll', [PayrollController::class, 'store']);
Route::get('/payroll/{id}', [PayrollController::class, 'show']);

Route::resource('payroll', PayrollController::class);
Route::get('/leave-request/{id}/edit', function ($id) {

    $leaveRequest = [
        'id' => $id,
        'employee_id' => 'EMP001',
        'employee_name' => 'Susanti Wijaya',
        'start_date' => '2026-06-10',
        'end_date' => '2026-06-12',
        'reason' => 'Liburan keluarga',
        'status' => 'Pending',
    ];

    return view(
        'leave_request.edit',
        compact('leaveRequest')
    );

})->name('leave_request.edit');

Route::put('/leave-request/{id}', function ($id) {

    return redirect()
        ->route('leave_request.index')
        ->with('success', 'Data cuti berhasil diperbarui.');

})->name('leave_request.update');
