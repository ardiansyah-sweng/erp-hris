<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\JobroleController;

Route::post('/test-jobrole', [JobroleController::class, 'store']);

Route::get('/cashiers', [\App\Http\Controllers\EmployeeController::class, 'getCashiers']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::post('/test-jobrole', [JobroleController::class, 'store']);

Route::post('/employees', [EmployeeController::class, 'store']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});

Route::delete('/job-roles/{jobrole}', [JobroleController::class, 'destroy']);
Route::get('/job-roles/{id}', [JobroleController::class, 'show']);

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
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
