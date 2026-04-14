<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 

// Route dari komputer kamu
Route::post('/employees', [EmployeeController::class, 'store']);

// Route dari GitHub (milik tim/hasil pull)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-roles', function () {
    return view('job_role.index');
});