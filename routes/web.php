<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 
use App\Http\Controllers\JobroleController;


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

Route::delete('/job-roles/{id}', [JobroleController::class, 'destroy']);