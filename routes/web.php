<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobroleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AttendanceController;


Route::get('/employees/status', [EmployeeController::class, 'indexByStatus']);
Route::post('/test-jobrole', [JobroleController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/job-roles', [JobroleController::class, 'store'])
    ->name('jobrole.store');

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/job-roles', function () {
    return view('job_role.index');
})->name('jobrole.index');

// ROUTE HALAMAN TAMBAH JOB ROLE
Route::get('/job-roles/create', function () {
    return view('job_role.create_jobrole');
})->name('jobrole.create');

Route::delete('/job-roles/{jobrole}', [JobroleController::class, 'destroy']);
Route::get('/job-roles/{id}', [JobroleController::class, 'show']);

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

Route::get('/leave-request', [LeaveRequestController::class, 'index'])
    ->name('leave_request.index');

Route::get('/leave-request/create', [LeaveRequestController::class, 'create'])
    ->name('leave_request.create');

Route::post('/leave-request', [LeaveRequestController::class, 'store'])
    ->name('leave_request.store');

Route::get('/leave-request/{id}/edit', [LeaveRequestController::class, 'edit'])
    ->name('leave_request.edit');

Route::put('/leave-request/{id}', [LeaveRequestController::class, 'update'])
    ->name('leave_request.update');

Route::delete('/leave-request/{id}', [LeaveRequestController::class, 'destroy'])
    ->name('leave_request.destroy');

Route::get('/leave-request/{id}', [LeaveRequestController::class, 'show'])
    ->name('leave_request.detail');

Route::get('/payroll/create', function () {
    $employees = Employee::orderBy('name')->get(['id', 'name']);

    return view('payroll.create', compact('employees'));
})->name('payroll.create');

Route::post('/payroll', [PayrollController::class, 'store']);
// Route export WAJIB di atas '/payroll/{id}' agar 'export' tidak ditangkap sebagai id
Route::get('/payroll/export', [PayrollController::class, 'export'])->name('payroll.export');
Route::get('/payroll/{id}', [PayrollController::class, 'show']);
Route::put('/payroll/{id}', [PayrollController::class, 'update']);
Route::delete('/payroll/{id}', [PayrollController::class, 'destroy']);

// ATTENDANCE ROUTES
Route::get('/attendance', [AttendanceController::class, 'index'])
    ->name('attendance.index');

Route::get('/attendance/{id}', [AttendanceController::class, 'show'])
    ->name('attendance.detail');

Route::resource('payroll', PayrollController::class);
Route::resource('payroll', PayrollController::class)->except(['create']);

Route::get('/system-audit-temp', [AuditLogController::class, 'indexTemp'])->name('system.audit.temp');
