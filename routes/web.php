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

Route::post('/job-roles', [JobroleController::class, 'store'])
    ->name('jobrole.store');

Route::post('/employees', [EmployeeController::class, 'store']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/job-roles', [JobroleController::class, 'index'])
    ->name('jobrole.index');

// ROUTE HALAMAN TAMBAH JOB ROLE
Route::get('/job-roles/create', function () {
    return view('job_role.create_jobrole');
})->name('jobrole.create');

// ROUTE DETAIL JOB ROLE
Route::get('/job-roles/{id}', [JobroleController::class, 'show'])
    ->name('jobrole.show');

// ROUTE EDIT JOB ROLE
Route::get('/job-roles/{id}/edit', [JobroleController::class, 'edit'])
    ->name('jobrole.edit');

// ROUTE UPDATE JOB ROLE
Route::put('/job-roles/{id}', [JobroleController::class, 'update'])
    ->name('jobrole.update');

// ROUTE DELETE JOB ROLE
Route::delete('/job-roles/{id}', [JobroleController::class, 'destroy'])
    ->name('jobrole.destroy');


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
