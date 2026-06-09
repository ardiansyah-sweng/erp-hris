<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 

Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
Route::post('/employees', [EmployeeController::class, 'store']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});