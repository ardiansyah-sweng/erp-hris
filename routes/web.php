<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobroleController;
use App\Http\Controllers\EmployeeController;

Route::post('/employees', [EmployeeController::class, 'store']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

Route::get('/detail-employee', function () {
    return view('employee.detail');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});

Route::post('/test-jobrole', [JobroleController::class, 'store']);
