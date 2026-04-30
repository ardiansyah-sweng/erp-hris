<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobroleController;
use App\Http\Controllers\EmployeeController; 

Route::post('/test-jobrole', [JobroleController::class, 'store']);
Route::post('/employees', [EmployeeController::class, 'store']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/job_role/edit', function () {
    $jobrole = (object)[
        'id' => 1,
        'name' => 'Admin',
        'description' => 'Mengelola sistem'
    ];

    return view('job_role.edit', compact('jobrole'));
});