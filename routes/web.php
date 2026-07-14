<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobroleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;

use App\Http\Controllers\PerformanceEvaluationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;

Route::get('/employees/status', [EmployeeController::class, 'indexByStatus']);
Route::post('/test-jobrole', [JobroleController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/employees/import', [EmployeeController::class, 'importCsv'])->name('employees.import');
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

Route::get('/detail-employee', function () {
    $employee = Employee::first() ?? new Employee();
    return view('employee.detail', compact('employee'));
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/job-roles', [JobroleController::class, 'store'])
    ->name('jobrole.store');

Route::post('/employees', [EmployeeController::class, 'store']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/detail-employee', function () {
    $employee = Employee::first() ?? new Employee();
    return view('employee.detail', compact('employee'));
});

Route::get('/job-roles', function () {
    return view('job_role.index');
})->name('jobrole.index');

// ROUTE HALAMAN TAMBAH JOB ROLE
Route::get('/job-roles/create', function () {
    return view('job_role.create_jobrole');
})->name('jobrole.create');

Route::delete('/job-roles/{jobrole}', [JobroleController::class, 'destroy']);
Route::get('/job-roles/{id}', [JobroleController::class, 'show']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::middleware('auth')->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/profile', function () {
    return view('profile.index');
})->name('profile.index');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    // DELETE FOTO PROFILE
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])
        ->name('profile.photo.delete');


    // SETTINGS
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');


    Route::put('/settings',
        [SettingController::class, 'update']
    )->name('settings.update');


    Route::put('/settings/password',
        [SettingController::class, 'updatePassword']
    )->name('settings.password');

});

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
Route::get('/attendance-recap', [AttendanceController::class, 'recap'])
    ->name('attendance.recap');

Route::resource('payroll', PayrollController::class)->except(['create']);
Route::resource('evaluations', PerformanceEvaluationController::class)->except(['show']);
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

Route::get('/system-audit-temp', [AuditLogController::class, 'indexTemp'])->name('system.audit.temp');

Route::prefix('announcement')->group(function () {

    Route::get(
        '/',
        [AnnouncementController::class, 'index']
    )->name('announcement.index');

    Route::get(
        '/{id}',
        [AnnouncementController::class, 'show']
    )->name('announcement.show');

});

});